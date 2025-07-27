# Argora Foundry

[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

**Argora Foundry** is a lightweight and extensible PHP boilerplate built to accelerate the development of modern control panels, SaaS platforms, and internal tools. Designed with developer productivity in mind, it combines a clean architecture, reusable components, and a ready-to-use user panel to help you launch faster—without compromising flexibility or quality.

## 🚀 Features

- **Modular Architecture** – Organize your code effortlessly with a clear, scalable structure inspired by proven patterns.
- **Built-in Control Panel** – A modern and customizable UI template for managing users, settings, and services out of the box.
- **SaaS-Ready** – Includes essential SaaS features like user authentication, roles & permissions, usage tracking, and more.
- **Modern Stack** – Powered by PHP 8+, Slim 4 Framework, Twig templates, and Tabler UI for a clean frontend.
- **Argora Spark API** – A dedicated, extensible API layer for advanced logic, automation, and integration beyond basic CRUD, ideal for smart provisioning and external system hooks.
- **Extensible** – Designed to be extended with custom modules.

## 🛠️ Ideal For

- SaaS startups launching fast without reinventing the wheel  
- Developers building internal dashboards or admin panels  
- Agencies delivering multiple client control panels from a common core

## 🧱 Philosophy

*Argora Foundry* is not a full-stack framework, but a focused foundation. It gives you the essentials—routing, user management, templates, modular structure—without locking you in. You stay in control of your stack, while we handle the heavy lifting.

## 🧩 Components

(TBD)

| Category | Package | Integrated |
| --- | --- | --- |
| Storage | [league/flysystem](https://packagist.org/packages/league/flysystem) | ❌ |
| Cookies | consider [dflydev/dflydev-fig-cookies] | ❌ |(https://packagist.org/packages/dflydev/dflydev-fig-cookies) | ❌ |
| Session | consider [compwright/php-session](compwright/php-session) | ❌ |
| Cache | [pinga/cache](https://github.com/getpinga/cache) or [matthiasmullie/scrapbook](https://packagist.org/packages/matthiasmullie/scrapbook) | ❌ |
| Backup | [PHPBU](https://phpbu.de/) | ❌ |
| Payment | [utopia-php/pay](https://packagist.org/packages/utopia-php/pay) | ❌ |
| DB Audit | [setbased/php-audit](https://packagist.org/packages/setbased/php-audit) | ❌ |
| KYC | [Ballerine](https://github.com/ballerine-io/ballerine) | ❌ | N/A | ❌ |
| Benchmark | [eypsilon/MycroBench](https://packagist.org/packages/eypsilon/MycroBench) or [phpbench/phpbench](https://packagist.org/packages/phpbench/phpbench) | ❌ |

## 📦 Installation

To create a new project using Argora Foundry:

```bash
composer create-project argora/foundry your-project-name
cd your-project-name
cp env-sample .env
chmod -R 775 logs cache
chown -R www-data:www-data logs cache
```

Configure your `.env` with database and app settings, and set your admin credentials in `bin/create-admin-user.php`.

```bash
php bin/install-db.php
php bin/create-admin-user.php
php -S localhost:8080 -t public
```

## 🙏 Acknowledgments

Argora Foundry is based on [hezecom/slim-starter](https://github.com/omotsuebe/slim-starter), an excellent Slim Framework 4 starter project by [Hezekiah Omotsuebe](https://github.com/omotsuebe).  
We’ve extended and restructured it for SaaS platforms, admin panels, and modern boilerplate needs.