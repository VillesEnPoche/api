Villes en poche - API / Website
=================================

## Installation

```bash
git clone git@github.com:VillesEnPoche/api.git ma-ville.en-poche
cp .env.example .env
nano .env
composer install
npm install && npm run prod
php artisan storage:link
php artisan migrate
php artisan db:seed
```

## Personnalisation de la ville

La variable APP_CITY du fichier .env sert à définir la ville.
Elle est utilisée pour copier les images du dossier `/resources/cities/${APP_CITY}/` (dont le logo).

La latitude / longitude est également à définir.

### Menu

Pour personnaliser le menu, vous pouvez activer une catégorie dans le fichier .env :

```dotenv
MENU_ENABLE_DAILY=false
MENU_ENABLE_GO_OUT=true
MENU_ENABLE_CONVENIENCE=true
MENU_ENABLE_MOVE=true
MENU_ENABLE_EMERGENCY=true
```

Dans ce cas, toute la partie "Au quotidien sera désactivée"

Pour supprimer une page d'un sous menu, vous pouvez utiliser une variable `SUBMENU_DISABLE_KEY`
ou `KEY` représente la clé du tableau de la page à désactiver :

```dotenv
SUBMENU_DISABLE_SILEX=true
```

La page du Silex sera désactivée.


## Contributions

- Convention de nommage de commit / PR : Angular
- PHP-CS-Fixer (.php_cs)
- Les tests Travis doivent passer

## Traductions

Pour traduire l'application dans une nouvelle langue, vous pouvez copier les fichiers de `resources/lang/fr/` dans le dossier de la langue à traduire.