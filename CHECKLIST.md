# Checklist Implémentation

## Backend (climbing-live-api)

- [x] Structure Symfony 7.2
- [x] 3 entités: Athlete, Competition, Camera
- [x] Repositories avec méthodes utiles
- [x] Controllers REST complets
- [x] Configuration Doctrine
- [x] Configuration Serializer
- [x] Docker Compose
- [ ] ✅ **À FAIRE**: CORS configuration
- [ ] ✅ **À FAIRE**: JWT Authentication
- [ ] ✅ **À FAIRE**: Validation des données
- [ ] ✅ **À FAIRE**: Exception handling
- [ ] ✅ **À FAIRE**: Tests unitaires

## Frontend (climbing-live)

- [x] Structure Next.js 16
- [ ] ✅ **À FAIRE**: Supprimer `/api/backend/*`
- [ ] ✅ **À FAIRE**: Supprimer `/api/internal/*`
- [ ] ✅ **À FAIRE**: Créer `/lib/api.ts` pour appels Backend
- [ ] ✅ **À FAIRE**: Ajouter `.env.local`
- [ ] ✅ **À FAIRE**: Intégrer appels Athletes
- [ ] ✅ **À FAIRE**: Intégrer appels Competitions
- [ ] ✅ **À FAIRE**: Intégrer appels Cameras
- [ ] ✅ **À FAIRE**: Gestion des erreurs

## Intégration

- [ ] CORS entre Frontend et Backend
- [ ] WebSocket pour live updates
- [ ] Cache côté Frontend
- [ ] Pagination API

## Tests

- [ ] Tests Backend (PHPUnit)
- [ ] Tests Frontend (Jest/Vitest)
- [ ] Tests d'intégration
- [ ] Tests e2e (Playwright)

## Déploiement

- [ ] Configuration prod Backend
- [ ] Configuration prod Frontend
- [ ] Secrets management
- [ ] CI/CD pipelines
