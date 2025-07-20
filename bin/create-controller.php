#!/usr/bin/env php
<?php
/**
 * Argora Foundry
 *
 * A modular PHP boilerplate for building SaaS applications, admin panels, and control systems.
 *
 * @package    App
 * @author     Taras Kondratyuk <help@argora.org>
 * @copyright  Copyright (c) 2025 Argora
 * @license    MIT License
 * @link       https://github.com/getargora/foundry
 */

if ($argc < 2) {
    echo "Usage: php create-controller.php [Name]\n";
    exit(1);
}

$name = ucfirst($argv[1]);
$class = "{$name}Controller";
$controllerFile = __DIR__ . "/../app/Controllers/{$class}.php";
$viewsDir = __DIR__ . "/../resources/views/" . strtolower($name);

//
// 1. Create Controller
//
if (file_exists($controllerFile)) {
    echo "Controller already exists: $controllerFile\n";
} else {
    $template = <<<PHP
<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class $class
{
    protected Twig \$view;

    public function __construct(Twig \$view)
    {
        \$this->view = \$view;
    }

    public function index(Request \$request, Response \$response): Response
    {
        return \$this->view->render(\$response, '$name/index.twig');
    }

    public function show(Request \$request, Response \$response, array \$args): Response
    {
        return \$this->view->render(\$response, '$name/show.twig', ['id' => \$args['id'] ?? null]);
    }

    public function create(Request \$request, Response \$response): Response
    {
        return \$this->view->render(\$response, '$name/create.twig');
    }

    public function update(Request \$request, Response \$response, array \$args): Response
    {
        return \$this->view->render(\$response, '$name/update.twig', ['id' => \$args['id'] ?? null]);
    }

    public function delete(Request \$request, Response \$response, array \$args): Response
    {
        return \$this->view->render(\$response, '$name/delete.twig', ['id' => \$args['id'] ?? null]);
    }
}
PHP;

    file_put_contents($controllerFile, $template);
    echo "✅ Created controller: $controllerFile\n";
}

//
// 2. Create View Directory and Files
//
if (is_dir($viewsDir)) {
    echo "⚠️  View directory already exists: $viewsDir\n";
} else {
    mkdir($viewsDir, 0775, true);

    $files = ['index', 'show', 'create', 'update', 'delete'];
    foreach ($files as $file) {
        $path = "$viewsDir/$file.twig";
        file_put_contents($path, "<h1>$name - $file</h1>");
    }

    echo "✅ Created Twig view directory and files in: $viewsDir\n";
}
