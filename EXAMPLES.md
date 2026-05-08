# Exemples d'Utilisation API

## Athletes

### Créer un grimpeur
```bash
curl -X POST http://localhost:8000/api/athletes \
  -H "Content-Type: application/json" \
  -d '{
    "firstName": "Jean",
    "lastName": "Martin",
    "bib": "001",
    "category": "senior"
  }'
```

**Réponse (201):**
```json
{
  "id": 1,
  "firstName": "Jean",
  "lastName": "Martin",
  "bib": "001",
  "category": "senior"
}
```

### Lister tous les grimpeurs
```bash
curl http://localhost:8000/api/athletes
```

### Récupérer un grimpeur
```bash
curl http://localhost:8000/api/athletes/1
```

### Modifier un grimpeur
```bash
curl -X PATCH http://localhost:8000/api/athletes/1 \
  -H "Content-Type: application/json" \
  -d '{"category": "elite"}'
```

### Supprimer un grimpeur
```bash
curl -X DELETE http://localhost:8000/api/athletes/1
```

---

## Competitions

### Créer une compétition
```bash
curl -X POST http://localhost:8000/api/competitions \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Coupe Nationale 2026",
    "location": "Chamonix",
    "startAt": "2026-06-15T09:00:00Z",
    "status": "scheduled"
  }'
```

**Réponse (201):**
```json
{
  "id": 1,
  "name": "Coupe Nationale 2026",
  "location": "Chamonix",
  "startAt": "2026-06-15T09:00:00Z",
  "endAt": null,
  "status": "scheduled"
}
```

### Lister toutes les compétitions
```bash
curl http://localhost:8000/api/competitions
```

### Modifier le status (en direct)
```bash
curl -X PATCH http://localhost:8000/api/competitions/1 \
  -H "Content-Type: application/json" \
  -d '{"status": "live"}'
```

---

## Cameras

### Enregistrer une caméra
```bash
curl -X POST http://localhost:8000/api/cameras \
  -H "Content-Type: application/json" \
  -d '{
    "id": "cam-001",
    "name": "Caméra Regie",
    "location": "Base de la falaise",
    "status": "offline",
    "authorized": true,
    "rtmpUrl": "rtmp://localhost:1935/live/cam-001",
    "hlsUrl": "http://localhost:8888/live/cam-001.m3u8"
  }'
```

### Lister les caméras autorisées
```bash
curl http://localhost:8000/api/cameras
```

### Mettre en ligne une caméra
```bash
curl -X PATCH http://localhost:8000/api/cameras/cam-001 \
  -H "Content-Type: application/json" \
  -d '{"status": "online"}'
```

---

## Codes HTTP

| Code | Signification |
|------|---------------|
| 200 | OK |
| 201 | Créé |
| 204 | Pas de contenu (DELETE) |
| 400 | Erreur de requête |
| 404 | Non trouvé |
| 500 | Erreur serveur |

---

## Frontend (Next.js)

### Appel API depuis React
```typescript
// src/lib/api.ts
const API_URL = process.env.NEXT_PUBLIC_API_URL;

export async function getAthletes() {
  const res = await fetch(`${API_URL}/api/athletes`);
  return res.json();
}

export async function createAthlete(data: any) {
  const res = await fetch(`${API_URL}/api/athletes`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  return res.json();
}
```

### Utilisation dans un composant
```typescript
// app/admin/page.tsx
'use client';

import { useEffect, useState } from 'react';
import { getAthletes } from '@/lib/api';

export default function Admin() {
  const [athletes, setAthletes] = useState([]);

  useEffect(() => {
    getAthletes().then(setAthletes);
  }, []);

  return (
    <div>
      {athletes.map(a => (
        <div key={a.id}>{a.firstName} {a.lastName}</div>
      ))}
    </div>
  );
}
```

---

## Configuration .env

### Frontend (climbing-live-web)
```env
NEXT_PUBLIC_API_URL=http://localhost:8000
```

### Backend (climbing-live-api)
```env
APP_ENV=dev
APP_SECRET=your-secret-key
DATABASE_URL=sqlite:///%kernel.project_dir%/var/app.db
```

---

Date: 8 mai 2026
