* @readonly
* Climbing Live API Backend

## 3 Entités principais:

1. **Competition** (Compétition)
   - id: integer
   - name: string
   - location: string
   - startAt: datetime
   - endAt: datetime (nullable)
   - status: enum('scheduled', 'live', 'finished')

2. **Athlete** (Grimpeur)
   - id: integer
   - firstName: string
   - lastName: string
   - bib: string (nullable)
   - category: string

3. **Camera** (Caméra)
   - id: string
   - name: string
   - location: string
   - status: enum('online', 'offline')
   - rtmpUrl: string (nullable)
   - hlsUrl: string (nullable)
   - authorized: boolean

## Routes API

- GET/POST `/api/competitions` - Gestion des compétitions
- GET/POST `/api/athletes` - Gestion des grimpeurs
- GET/POST `/api/cameras` - Gestion des caméras

Chaque entité supporte: GET (list + detail), POST (create), PATCH/PUT (update), DELETE
