# Foresi skeleton

The starting point of a [Foresi](https://foresi.app) application: an open-source business system for small firms. It installs the core and the screens; you add the modules you need.

Foresi is developed in [foresi/foresi](https://github.com/foresi/foresi). Report issues and send changes there; this repository only holds the application shell.

## Requirements

- PHP 8.4 with the ctype, dom, gd, iconv, intl, sodium and zip extensions, and pdo_pgsql
- PostgreSQL 17
- Composer 2

## Create an application

```bash
composer create-project foresi/skeleton my-foresi
cd my-foresi
```

Put the settings of this installation in `.env.local` (never commit it):

```dotenv
APP_ENV=prod
APP_SECRET=<a long random string>
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/foresi?serverVersion=17&charset=utf8"
DEFAULT_URI=https://foresi.example.com
```

`.env` lists every other setting with its default.

Then create the schema and build the assets:

```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console tailwind:build --minify
php bin/console asset-map:compile
```

Point the web server at `public/`. Run the workers with `php bin/console messenger:consume scheduler_foresi mail events async webhooks registry`.

## Add modules

A module is a Composer package. Installed means enabled: its screens, API, migrations and settings come with it, and nothing is listed by hand.

```bash
composer require foresi/work foresi/invoicing
php bin/console doctrine:migrations:migrate --no-interaction
```

The published modules are [listed on Packagist](https://packagist.org/packages/foresi/). Removing one with `composer remove` removes its screens and routes; its tables stay until you drop them.

## Configuration

The packages bring their whole configuration. A file in `config/packages/` overrides any of it for this installation, for example `config/packages/mailer.yaml`. Security access rules come from the packages and cannot be extended there yet.

Your own code goes in `src/` (namespace `App\`). A module of your own can live in `modules/` as a Composer path repository.

## Updates

Versions follow Foresi's releases. Under 0.x, `^0.9` stays within 0.9:

```bash
composer update 'foresi/*'
php bin/console doctrine:migrations:migrate --no-interaction
```

## Deploy

`ops/` holds the deploy, backup, restore and rollback scripts, with systemd units and a Ploi deploy script. They are described in the [operations guide](https://github.com/foresi/foresi/blob/main/docs/operations.md). `ops/deploy.sh` reads `REPO_URL`, the git URL of your application, from `deploy.env`.

## Licence

AGPL-3.0-only. See [LICENSE](LICENSE).
