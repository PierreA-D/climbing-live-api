# Climbing Live API

API Symfony minimaliste pour la gestion de compétitions d'escalade.

## Endpoints

### Competitions
- `GET /api/competitions` - Liste toutes les compétitions
- `GET /api/competitions/{id}` - Récupère une compétition
- `POST /api/competitions` - Crée une compétition
- `PATCH /api/competitions/{id}` - Met à jour une compétition
- `DELETE /api/competitions/{id}` - Supprime une compétition

### Athletes  
- `GET /api/athletes` - Liste tous les grimpeurs
- `GET /api/athletes/{id}` - Récupère un grimpeur
- `POST /api/athletes` - Crée un grimpeur
- `PATCH /api/athletes/{id}` - Met à jour un grimpeur
- `DELETE /api/athletes/{id}` - Supprime un grimpeur

### Cameras
- `GET /api/cameras` - Liste toutes les caméras
- `GET /api/cameras/{id}` - Récupère une caméra
- `POST /api/cameras` - Crée une caméra
- `PATCH /api/cameras/{id}` - Met à jour une caméra
- `DELETE /api/cameras/{id}` - Supprime une caméra

## Installation

```bash
cd climbing-live-api
composer install
```

## Configuration

Copier `.env.local.example` en `.env.local` et adapter la base de données.

## Développement

```bash
symfony serve
```

L'API sera accessible sur `http://localhost:8000`

## Docker

```bash
docker-compose up -d
```
