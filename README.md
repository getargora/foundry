# Argora Foundry

[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

**Argora Foundry** is a lightweight and extensible PHP boilerplate built to accelerate the development of modern control panels, SaaS platforms, and internal tools. Designed with developer productivity in mind, it combines a clean architecture, reusable components, and a ready-to-use user panel to help you launch faster—without compromising flexibility or quality.

## 🚀 Features

- **Modular Architecture** – Organize your code effortlessly with a clear, scalable structure inspired by proven patterns.
- **Built-in Control Panel** – A modern and customizable UI template for managing users, settings, and services out of the box.
- **SaaS-Ready** – Includes essential SaaS features like user authentication, roles & permissions, usage tracking, and more.
- **Modern Stack** – Powered by PHP 8+, Slim 4 Framework, Twig templates, and Tabler UI for a clean frontend.
- **Extensible & Tested** – Designed to be extended with custom modules, and includes support for PHPUnit or Pest for reliable testing.

## 🛠️ Ideal For

- SaaS startups launching fast without reinventing the wheel  
- Developers building internal dashboards or admin panels  
- Agencies delivering multiple client control panels from a common core

## 🧱 Philosophy

*Argora Foundry* is not a full-stack framework, but a focused foundation. It gives you the essentials—routing, user management, templates, modular structure—without locking you in. You stay in control of your stack, while we handle the heavy lifting.

## 🧩 Components

(TBD)

| Category | Package | Integrated |
| --- | --- | --- | --- | --- |
| Authentication | [pinga/auth](https://packagist.org/packages/pinga/auth) | ✅ |
| Storage | [league/flysystem](https://packagist.org/packages/league/flysystem) | ❌ |
| Database | [pinga/db](https://packagist.org/packages/pinga/db) | ✅ |
| DI | [php-di/php-di](https://packagist.org/packages/php-di/php-di) | ✅ |
| PSR-7/17 | [nyholm/psr7](https://packagist.org/packages/nyholm/psr7) | ✅ |
| Logging | [monolog/monolog](https://packagist.org/packages/monolog/monolog) | ✅ |
| Templates | [twig/twig](https://packagist.org/packages/twig/twig) | ✅ |
| Forms | [jarzon/form](https://packagist.org/packages/jarzon/form) | ❌ |
| Cookies | [pinga/cookie](https://packagist.org/packages/pinga/cookie) or [dflydev/dflydev-fig-cookies] | ❌ |(https://packagist.org/packages/dflydev/dflydev-fig-cookies) | ❌ |
| Session | [pinga/session](https://packagist.org/packages/pinga/session) or [compwright/php-session](compwright/php-session)<br>[neoflow/session](neoflow/session) | ❌ |
| Cache | [pinga/cache](https://github.com/getpinga/cache) or [matthiasmullie/scrapbook](https://packagist.org/packages/matthiasmullie/scrapbook) | ❌ |
| 2FA | [robthree/twofactorauth](https://packagist.org/packages/robthree/twofactorauth) | ❌ |
| Backup | [PHPBU](https://phpbu.de/) | ❌ |
| Payment | [utopia-php/pay](https://packagist.org/packages/utopia-php/pay) | ❌ |
| Messaging | [utopia-php/messaging](https://packagist.org/packages/utopia-php/messaging) | ❌ |
| User Audit | [utopia-php/audit](https://packagist.org/packages/utopia-php/audit) | ❌ |
| DB Audit | [setbased/php-audit](https://packagist.org/packages/setbased/php-audit) | ❌ |
| KYC | [Ballerine](https://github.com/ballerine-io/ballerine) | ❌ | N/A | ❌ |
| Admin UI | [Tabler](https://github.com/tabler/tabler) | ✅ | ❌ | ❌ |
| Benchmark | [eypsilon/MycroBench](https://packagist.org/packages/eypsilon/MycroBench) or [phpbench/phpbench](https://packagist.org/packages/phpbench/phpbench) | ❌ |
| Tests | [Pest](https://pestphp.com/) | ❌ |

## 📦 Installation

To create a new project using Argora Foundry:

```bash
composer create-project argora/foundry your-project-name
cd your-project-name
cp env-sample .env
```

Make sure to configure your `.env` with your database and app settings.

```bash
php bin/install-db.php
php -S localhost:8080 -t public
```

## ℹ️ Details

Based on Slim 4 and hezecom/slim-starter
