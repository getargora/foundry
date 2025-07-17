# Argora Foundry

[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

**Argora Foundry** is a lightweight and extensible PHP boilerplate built to accelerate the development of modern control panels, SaaS platforms, and internal tools. Designed with developer productivity in mind, it combines a clean architecture, reusable components, and a ready-to-use user panel to help you launch faster—without compromising flexibility or quality.

## 🚀 Key Features

- **Modular Architecture** – Organize your code effortlessly with a clear, scalable structure inspired by proven patterns.
- **Built-in Control Panel** – A modern and customizable UI template for managing users, settings, and services out of the box.
- **SaaS-Ready** – Includes essential SaaS features like user authentication, roles & permissions, usage tracking, and more.
- **Modern Stack** – Powered by PHP 8+, Slim Framework, Twig templates, and Tabler UI for a clean frontend.
- **Extensible & Tested** – Designed to be extended with custom modules, and includes support for PHPUnit or Pest for reliable testing.

## 🛠️ Ideal For

- SaaS startups launching fast without reinventing the wheel  
- Developers building internal dashboards or admin panels  
- Agencies delivering multiple client control panels from a common core

## 🧱 Philosophy

*Argora Foundry* is not a full-stack framework, but a focused foundation. It gives you the essentials—routing, user management, templates, modular structure—without locking you in. You stay in control of your stack, while we handle the heavy lifting.

## Components

(TBD)

| Category | Package | Integrated | Alternative | Integrated |
| --- | --- | --- | --- | --- |
| Routing | [slim/slim](https://packagist.org/packages/slim/slim) | ✅ | [phpleague/route](https://packagist.org/packages/league/route) | ❌ |
| Authentication | [pinga/auth](https://packagist.org/packages/pinga/auth) | ✅ | [jasny/auth](https://packagist.org/packages/jasny/auth) | ❌ |
| Storage | [league/flysystem](https://packagist.org/packages/league/flysystem) | ❌ | N/A | ❌ |
| Database | [pinga/db](https://packagist.org/packages/pinga/db) | ✅ | [pinga/db-swoole](https://github.com/getpinga/db-swoole)<br>[pinga/db-pool](https://github.com/getpinga/db-pool) | ✅ | ❌ |
| DI | [php-di/php-di](https://packagist.org/packages/php-di/php-di) | ✅ | N/A | ❌ |
| PSR-7/17 | [nyholm/psr7](https://packagist.org/packages/nyholm/psr7) | ✅ | N/A | ❌ |
| Logging | [monolog/monolog](https://packagist.org/packages/monolog/monolog)<br>[wyrihaximus/monolog-formatted-psr-handler](https://packagist.org/packages/wyrihaximus/monolog-formatted-psr-handler) | ✅ | N/A | ❌ |
| Templates | [twig/twig](https://packagist.org/packages/twig/twig) | ✅ | [league/plates](https://packagist.org/packages/league/plates) | ❌ |
| Menu | [twig/twig](https://packagist.org/packages/twig/twig) | ✅ | [spatie/menu](https://packagist.org/packages/spatie/menu) | ❌ |
| Forms | [jarzon/form](https://packagist.org/packages/jarzon/form) | ❌ | N/A | ❌ |
| Data validation | [wixel/gump](https://packagist.org/packages/wixel/gump) | ❌ | N/A | ❌ |
| Configuration files | [vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv) | ✅ | N/A | ❌ |
| Cookies | [pinga/cookie](https://packagist.org/packages/pinga/cookie) | ✅ | [dflydev/dflydev-fig-cookies](https://packagist.org/packages/dflydev/dflydev-fig-cookies) | ❌ |
| Session | [pinga/session](https://packagist.org/packages/pinga/session) | ✅ | [compwright/php-session](compwright/php-session)<br>[neoflow/session](neoflow/session) | ❌ |
| Cache | [pinga/cache](https://github.com/getpinga/cache) | ❌ | [matthiasmullie/scrapbook](https://packagist.org/packages/matthiasmullie/scrapbook) | ❌ |
| 2FA | [robthree/twofactorauth](https://packagist.org/packages/robthree/twofactorauth) | ❌ | N/A | ❌ |
| SSL Management | [Acme PHP](https://acmephp.github.io/) | ❌ | N/A | ❌ |
| Load balancing | [gonzie/pdoload](https://packagist.org/packages/gonzie/pdoload) | ❌ | N/A | ❌ |
| Backup | [PHPBU](https://phpbu.de/) | ❌ | [Restic](https://restic.net/) | ❌ |
| Payment | [league/omnipay](https://packagist.org/packages/league/omnipay) | ❌ | [utopia-php/pay](https://packagist.org/packages/utopia-php/pay) | ❌ |
| Messaging | [utopia-php/messaging](https://packagist.org/packages/utopia-php/messaging) | ❌ | N/A | ❌ |
| User Audit | [utopia-php/audit](https://packagist.org/packages/utopia-php/audit) | ❌ | N/A | ❌ |
| DB Replication | Native DB Tools | ❌ | [gemini/php-mysql-replication](https://packagist.org/packages/gemini/php-mysql-replication) | ❌ |
| DB Optimization | [guanguans/soar-php](https://packagist.org/packages/guanguans/soar-php) | ❌ | N/A | ❌ |
| DB Pagination | [ozdemir/datatables](https://packagist.org/packages/ozdemir/datatables) | ❌ | [lazymofo/datagrid](https://github.com/lazymofo/datagrid) | ❌ |
| DB Audit | [setbased/php-audit](https://packagist.org/packages/setbased/php-audit) | ❌ | N/A | ❌ |
| KYC | [Ballerine](https://github.com/ballerine-io/ballerine) | ❌ | N/A | ❌ |
| Admin UI | [Tabler](https://github.com/tabler/tabler) | ✅ | ❌ | ❌ |
| Machine Learning | [MindsDB](https://mindsdb.com/) | ❌ | N/A | ❌ |
| Benchmark | [eypsilon/MycroBench](https://packagist.org/packages/eypsilon/MycroBench) | ❌ | [phpbench/phpbench](https://packagist.org/packages/phpbench/phpbench) | ❌ |
| Coding Standards | PHP CS | ❌ | PHP Stan | ❌ |
| Tests | [Pest](https://pestphp.com/) | ❌ | N/A | ❌ |
| Translation | [pinga/locale](https://packagist.org/packages/pinga/locale) | ❌ | [utopia-php/locale](https://packagist.org/packages/utopia-php/locale) | ❌ |
| PSR-14 Event Dispatcher | [leocavalcante/dispatch](https://packagist.org/packages/leocavalcante/dispatch) | ❌ | N/A | ❌ |

### Installation

1. Use installDB.php script to install the database.

2. Move env-sample to .env and configure.

### Details

Based on Slim 4 and hezecom/slim-starter
