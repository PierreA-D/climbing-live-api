# Installation

## Prérequis

- PHP >= 8.2
- Composer
- Node.js (optional, pour tooling)
- Docker + Docker Compose (optional)

## Développement Local

### 1. Installation

```bash
cd climbing-live-api
composer install
```

### 2. Configuration

```bash
cp .env.local.example .env.local
# Éditer .env.local si nécessaire
```

### 3. Base de Données

```bash
# Créer la DB PostgreSQL
bin/console doctrine:database:create
# Créer les tables
bin/console doctrine:schema:create
```

### 4. Démarrer le serveur

```bash
symfony serve
```

L'API sera disponible sur: **http://localhost:8000**

### 5. Tester l'API

```bash
curl http://localhost:8000/api/athletes
```

---

## Docker

```bash
docker-compose up -d
```

Services disponibles:
- API: http://localhost:8000
- PostgreSQL: localhost:5432

---

## Commandes Utiles

```bash
# Créer une entité
bin/console make:entity

# Créer une migration
bin/console make:migration
bin/console doctrine:migrations:migrate

# Dumper la DB
bin/console doctrine:schema:update --dump-sql

# Initialiser la DB de test
bin/console doctrine:database:create --env=test
```

---

## Variables d'Environnement

| Variable | Default | Description |
|----------|---------|-------------|
| `APP_ENV` | `dev` | Environnement (dev/test/prod) |
| `APP_SECRET` | - | Clé secrète Symfony |
| `DATABASE_URL` | PostgreSQL | URL de la DB |

Voir `.env.local.example` pour plus de détails.
