# Mini Insta

Mini Instagram avec upload de photos.

## Programme
Fondamentaux - PHP, Formulaires & Gestion de fichiers

## Prérequis
- Git (pour cloner le dépôt)
- Docker (pour la version conteneurisée)
- PHP (pour la version locale)

## Installation & Configuration

### En local
Cloner le projet
```bash
php -S localhost:8083
```
Ouvrir http://localhost:8083

### Avec Docker
```bash
docker build -t mini-insta .
docker run -d -p 8083:80 -v "/chemin/vers/mini_insta/photos":/var/www/html/photos --name mini-insta mini-insta
```
Ouvrir http://localhost:8083

## Port
| Hôte | Conteneur |
|------|-----------|
| 8083 | 80        |