# Climbing Live API

API Symfony pour piloter un environnement de competition d'escalade en direct.

Le projet expose des endpoints REST pour gerer les competitions, les athletes, les cameras et les parametres de diffusion. L'application tourne avec PHP 8.2, Symfony 7.4 et PostgreSQL, avec un environnement Docker pret a l'emploi.

## Fonctionnalites

- Authentification administrateur par jeton Bearer.
- Consultation publique en lecture seule des competitions, athletes et cameras.
- Operations d'administration protegees sur les ressources metier.
- Gestion des parametres de diffusion et d'integration MediaMTX.
- Migrations Doctrine lancees automatiquement au demarrage du conteneur applicatif.

## Stack technique

- PHP 8.2
- Symfony 7.4
- Doctrine ORM + Doctrine Migrations
- PostgreSQL 16
- Nginx + PHP-FPM + Supervisor
- Docker Compose

## Demarrage rapide

### Prerequis

- Docker
- Docker Compose

### Lancer le projet

```bash
docker compose up --build -d
```

### Lancer le projet en production

Le mode production utilise un fichier Compose dedie et un fichier d'environnement local ignore par Git.

Commande de demarrage:

```bash
docker compose -f docker-compose.prod.yml up --build -d
```

Variables utilisees:

- `.env.prod.local` pour `APP_ENV`, `APP_DEBUG`, `APP_SECRET`, `API_TOKEN_SECRET` et la configuration PostgreSQL.
- `docker-compose.prod.yml` pour lancer uniquement les services necessaires sans montage du code source ni exposition du port PostgreSQL.

Arret:

```bash
docker compose -f docker-compose.prod.yml down
```

L'API sera accessible sur l'adresse suivante:

```text
http://localhost:8000
```

La base PostgreSQL sera exposee sur:

```text
localhost:5432
```

avec les identifiants par defaut:

- Base: `climbing_live`
- Utilisateur: `climbing`
- Mot de passe: `climbing_secure_pwd`

## Variables d'environnement utiles

Le projet charge deja ses fichiers d'environnement Symfony habituels, notamment `.env` et `.env.dev`.

Variables importantes pour l'exploitation:

- `DATABASE_URL`: connexion PostgreSQL.
- `APP_ENV`: environnement Symfony.
- `APP_DEBUG`: active le mode debug.
- `APP_SECRET`: secret Symfony de base.
- `API_TOKEN_SECRET`: secret utilise pour signer les jetons API.
- `ADMIN_TOKEN_SECRET`: secret de secours si `API_TOKEN_SECRET` n'est pas defini.
- `ADMIN_EMAIL`: email admin utilise par la commande de creation.
- `ADMIN_PASSWORD`: mot de passe admin utilise par la commande de creation.

## Initialisation de l'administrateur

Les routes d'ecriture sur les ressources metier sont reservees au role administrateur. Creez d'abord un compte admin:

```bash
docker compose exec app php bin/console app:user:create-admin admin@climbing.live change-me
```

Alternative via variables d'environnement:

```bash
docker compose exec \
  -e ADMIN_EMAIL=admin@climbing.live \
  -e ADMIN_PASSWORD=change-me \
  app php bin/console app:user:create-admin
```

## Authentification

Connexion:

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@climbing.live",
    "password": "change-me"
  }'
```

Reponse attendue:

```json
{
  "user": {
    "email": "admin@climbing.live",
    "name": "admin@climbing.live",
    "role": "admin"
  },
  "token": "<bearer-token>",
  "expiresAt": "2026-06-02T12:00:00+00:00"
}
```

Utilisez ensuite le jeton dans l'en-tete suivant:

```text
Authorization: Bearer <bearer-token>
```

## Regles d'acces

- `GET /api/athletes`, `GET /api/cameras`, `GET /api/competitions`: acces public.
- `POST`, `PUT`, `PATCH`, `DELETE` sur `/api/athletes`, `/api/cameras`, `/api/competitions`: acces admin uniquement.
- `POST /api/auth/login`: acces public.
- `GET /api/settings`: accessible sans regle d'acces explicite supplementaire dans la configuration actuelle.

## Ressources exposees

### Competitions

Champs principaux:

- `id`
- `name`
- `location`
- `startAt`
- `endAt`
- `status`: `scheduled`, `live`, `finished`
- `category`: `block`, `speed`, `difficulty`, `team`

Exemple de creation:

```bash
curl -X POST http://localhost:8000/api/competitions \
  -H "Authorization: Bearer <bearer-token>" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Coupe regionale",
    "location": "Lyon",
    "startAt": "2026-06-10T09:00:00+00:00",
    "endAt": "2026-06-10T18:00:00+00:00",
    "status": "scheduled",
    "category": "block"
  }'
```

### Athletes

Champs principaux:

- `id`
- `firstName`
- `lastName`
- `bib`
- `category`

Exemple de creation:

```bash
curl -X POST http://localhost:8000/api/athletes \
  -H "Authorization: Bearer <bearer-token>" \
  -H "Content-Type: application/json" \
  -d '{
    "firstName": "Manon",
    "lastName": "Durand",
    "bib": "A12",
    "category": "senior"
  }'
```

### Cameras

Champs principaux:

- `id`
- `name`
- `location`
- `status`: `online`, `offline`
- `rtmpUrl`
- `hlsUrl`
- `authorized`
- `token`
- `blocked`
- `allowedPaths`
- `lastSeenAt`
- `lastIp`
- `lastProtocol`
- `currentPath`
- `competition`

Particularites:

- la creation passe par un DTO specifique;
- le champ `competition` doit etre une IRI de la forme `/api/competitions/{id}`;
- une camera nouvellement creee est initialisee en statut `offline`.

Exemple de creation:

```bash
curl -X POST http://localhost:8000/api/cameras \
  -H "Authorization: Bearer <bearer-token>" \
  -H "Content-Type: application/json" \
  -d '{
    "id": "cam-finale-1",
    "name": "Camera finale 1",
    "location": "Zone bloc A",
    "rtmpUrl": "rtmp://mediamtx/live/cam-finale-1",
    "hlsUrl": "http://localhost:8888/live/cam-finale-1/index.m3u8",
    "authorized": true,
    "token": "camera-secret",
    "blocked": false,
    "allowedPaths": ["live/cam-finale-1"],
    "lastSeenAt": "2026-06-11T12:00:00+00:00",
    "lastIp": "192.168.1.10",
    "lastProtocol": "rtmp",
    "currentPath": "live/cam-finale-1",
    "competition": "/api/competitions/1"
  }'
```

### Settings

La ressource `settings` expose la configuration fonctionnelle de diffusion, notamment:

- `mediamtxApiUrl`
- `hlsBaseUrl`
- `requireDeviceAuth`
- `allowUnknownDevices`
- `autoRegisterUnknownDevices`
- `autoAuthorizeNewDevices`
- `exposeOnlyAuthorizedPaths`
- `maxDevices`
- `maxConnectedDevices`
- `pollIntervalMs`
- `enablePublish`
- `enableRead`

Lecture:

```bash
curl http://localhost:8000/api/settings
```

## Endpoints principaux

| Methode | Endpoint | Description | Auth |
| --- | --- | --- | --- |
| POST | `/api/auth/login` | Connexion admin | Non |
| GET | `/api/competitions` | Lister les competitions | Non |
| GET | `/api/competitions/{id}` | Detail d'une competition | Non |
| POST | `/api/competitions` | Creer une competition | Oui |
| PATCH/PUT | `/api/competitions/{id}` | Modifier une competition | Oui |
| DELETE | `/api/competitions/{id}` | Supprimer une competition | Oui |
| GET | `/api/athletes` | Lister les athletes | Non |
| GET | `/api/athletes/{id}` | Detail d'un athlete | Non |
| POST | `/api/athletes` | Creer un athlete | Oui |
| PATCH/PUT | `/api/athletes/{id}` | Modifier un athlete | Oui |
| DELETE | `/api/athletes/{id}` | Supprimer un athlete | Oui |
| GET | `/api/cameras` | Lister les cameras | Non |
| GET | `/api/cameras/{id}` | Detail d'une camera | Non |
| POST | `/api/cameras` | Creer une camera | Oui |
| PATCH/PUT | `/api/cameras/{id}` | Modifier une camera | Oui |
| DELETE | `/api/cameras/{id}` | Supprimer une camera | Oui |
| GET | `/api/settings` | Lire la configuration applicative | Non |

## Commandes utiles

```bash
docker compose up --build -d
docker compose down
docker compose logs -f app
docker compose exec app php bin/console doctrine:migrations:migrate
docker compose exec app php bin/console app:user:create-admin admin@climbing.live change-me
```

## Notes d'exploitation

- Le conteneur applicatif applique les migrations Doctrine au demarrage.
- Le healthcheck HTTP du conteneur cible `/health`.
- Le secret de signature des jetons doit etre personnalise hors environnement local.
- Les modifications d'ecriture sur les ressources publiques de lecture necessitent un jeton admin valide.

## Structure du projet

```text
src/
  Controller/   Endpoints HTTP
  Entity/       Modeles Doctrine
  Security/     Authentification par jeton
  Command/      Commandes console
  Handler/      Logique applicative specifique
config/         Configuration Symfony
docker/         Configuration Nginx et Supervisor
migrations/     Historique Doctrine
```