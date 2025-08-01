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

use App\Lib\Logger;
use DI\Container;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\TwigFunction;
use Gettext\Loader\PoLoader;
use Gettext\Translations;
use Punic\Language;

// Enable for debug
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.cookie_lifetime', '0');
ini_set('session.hash_function', 'sha256');
ini_set('session.entropy_length', '32');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helper.php';

try {
    Dotenv\Dotenv::createImmutable(__DIR__. '/../')->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

//Enable error display in details when APP_ENV=local
if(envi('APP_ENV')=='local') {
    Logger::systemLogs(true);
}else{
    Logger::systemLogs(false);
}

// Set container to create App with on AppFactory
$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

$responseFactory = $app->getResponseFactory();

$routeCollector = $app->getRouteCollector();
$routeCollector->setCacheFile(__DIR__ . '/../cache/routes.php');
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());
$routeParser = $app->getRouteCollector()->getRouteParser();

require_once __DIR__ . '/database.php';

$container->set('router', function () use ($routeParser) {
    return $routeParser;
});

$container->set('db', function () use ($db) {
    return $db;
});

$container->set('pdo', function () use ($pdo) {
    return $pdo;
});

/* $container->set('db_audit', function () use ($db_audit) {
    return $db_audit;
});

$container->set('pdo_audit', function () use ($pdo_audit) {
    return $pdo_audit;
}); */

$container->set('auth', function() {
    //$responseFactory = new \Nyholm\Psr7\Factory\Psr17Factory();
    //$response = $responseFactory->createResponse();
    //$autoLogout = new \Pinga\Auth\AutoLogout();
    //$autoLogout->watch(900, '/', null, 301, $response);
    
    return new \App\Auth\Auth;
});

$container->set('flash', function() {
    return new \Slim\Flash\Messages;
});

$container->set('view', function ($container) {
    $view = Twig::create(__DIR__ . '/../resources/views', [
        'cache' => __DIR__ . '/../cache',
    ]);
    $view->getEnvironment()->addGlobal('auth', [
        'isLogin' => $container->get('auth')->isLogin(),
        'user' => $container->get('auth')->user(),
    ]);

    // Known set of languages
    $allowedLanguages = ['en_US'];

    if (isset($_SESSION['_lang']) && in_array($_SESSION['_lang'], $allowedLanguages)) {
        // Use regex to validate the format: two letters, underscore, two letters
        if (preg_match('/^[a-z]{2}_[A-Z]{2}$/', $_SESSION['_lang'])) {
            $desiredLanguage = $_SESSION['_lang'];
            $parts = explode('_', $_SESSION['_lang']);
            if (isset($parts[1])) {
                $uiLang = strtolower($parts[1]);
            }
        } else {
            $desiredLanguage = envi('LANG');
            $uiLang = envi('UI_LANG');
        }
    } else {
        $desiredLanguage = envi('LANG');
        $uiLang = envi('UI_LANG');
    }
    $lang_full = Language::getName($desiredLanguage, $uiLang);
    if ($uiLang === 'xx') {
        $lang = 'lang_name';
    } elseif (!empty($lang_full) && str_contains($lang_full, ' (')) {
        $lang = ucfirst(trim(strstr($lang_full, ' (', true)));
    } elseif (!empty($lang_full)) {
        $lang = ucfirst(trim($lang_full));
    } else {
        $lang = 'en_US';
    }

    $languageFile = '../lang/' . $desiredLanguage . '/messages.po';
    if (!file_exists($languageFile)) {
        $desiredLanguage = 'en_US'; // Fallback
        $languageFile = '../lang/en_US/messages.po';
    }

    $loader = new PoLoader();
    $translations = $loader->loadFile($languageFile);

    $view->getEnvironment()->addGlobal('uiLang', $uiLang);
    $view->getEnvironment()->addGlobal('lang', $lang);
    $view->getEnvironment()->addGlobal('_lang', substr($desiredLanguage, 0, 2));
    $view->getEnvironment()->addGlobal('flash', $container->get('flash'));

    $staticDir = realpath(__DIR__ . '/../public/static');

    $useBw = ($_SESSION['_screen_mode'] ?? 'light') === 'dark';
    $baseName = $useBw ? 'logo-bw' : 'logo';

    if (file_exists("$staticDir/{$baseName}.svg")) {
        $logoPath = "/static/{$baseName}.svg";
    } elseif (file_exists("$staticDir/{$baseName}.png")) {
        $logoPath = "/static/{$baseName}.png";
    } else {
        $logoPath = "/static/{$baseName}.default.svg";
    }

    $view->getEnvironment()->addGlobal('logoPath', $logoPath);

    if (isset($_SESSION['_screen_mode'])) {
        $view->getEnvironment()->addGlobal('screen_mode', $_SESSION['_screen_mode']);
    } else {
        $view->getEnvironment()->addGlobal('screen_mode', 'light');
    }
    if (isset($_SESSION['_theme'])) {
        $view->getEnvironment()->addGlobal('theme', $_SESSION['_theme']);
    } else {
        $view->getEnvironment()->addGlobal('theme', 'blue');
    }
    if (isset($_SESSION['auth_roles'])) {
        $view->getEnvironment()->addGlobal('roles', $_SESSION['auth_roles']);
    }
    $view->getEnvironment()->addFunction(new TwigFunction('has_any_role', function (int $userRoles, array $requiredRoles): bool {
        foreach ($requiredRoles as $role) {
            if (($userRoles & $role) !== 0) {
                return true;
            }
        }
        return false;
    }));

    // Fetch user currency
    $db = $container->get('db');

    if (isset($_SESSION['auth_user_id'])) {
        $user_data = $db->selectRow("SELECT id, currency FROM users WHERE id = ? LIMIT 1", [$_SESSION['auth_user_id']]);
        $_SESSION['_currency'] = $user_data['currency'] ?? 'EUR';
    } else {
        $_SESSION['_currency'] = 'EUR';
    }

    // Make it accessible in templates
    $view->getEnvironment()->addGlobal('currency', $_SESSION['_currency']);

    // Check if the user is impersonated from the admin, otherwise default to false
    $isAdminImpersonation = isset($_SESSION['impersonator']) ? $_SESSION['impersonator'] : false;
    $view->getEnvironment()->addGlobal('isAdminImpersonation', $isAdminImpersonation);

    $translateFunction = new TwigFunction('__', function ($text) use ($translations) {
        // Find the translation
        $translation = $translations->find(null, $text);
        if ($translation) {
            return $translation->getTranslation();
        }
        // Return the original text if translation not found
        return $text;
    });
    $view->getEnvironment()->addFunction($translateFunction);

    //route
    $route = new TwigFunction('route', function ($name) {
        return route($name);
    });
    $view->getEnvironment()->addFunction($route);
    
    // Define the route_is function
    $routeIs = new \Twig\TwigFunction('route_is', function ($routeName) {
        return strpos($_SERVER['REQUEST_URI'], $routeName) !== false;
    });
    $view->getEnvironment()->addFunction($routeIs);

    //assets
    $assets = new TwigFunction('assets', function ($location) {
        return assets($location);
    });
    $view->getEnvironment()->addFunction($assets);

    //Pagination
    $pagination = new TwigFunction("links", function ($object) {

    });
    $view->getEnvironment()->addFunction($pagination);

    return $view;
});
$app->add(TwigMiddleware::createFromContainer($app));

$container->set('validator', function ($container) {
    return new App\Lib\Validator;
});

$container->set('csrf', function($container) use ($responseFactory) {
    return new Slim\Csrf\Guard($responseFactory);
});

$app->add(new \App\Middleware\AuditMiddleware($container));
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$csrfMiddleware = function ($request, $handler) use ($container) {
    $uri = $request->getUri();
    $path = $uri->getPath();

    // Get the CSRF Guard instance from the container
    $csrf = $container->get('csrf');

    // Skip CSRF for the specific path
    if ($path && $path === '/webauthn/register/verify') {
        return $handler->handle($request);
    }
    if ($path && $path === '/webauthn/login/challenge') {
        return $handler->handle($request);
    }
    if ($path && $path === '/webauthn/login/verify') {
        return $handler->handle($request);
    }
    if ($path && $path === '/webhook/adyen') {
        return $handler->handle($request);
    }
    if ($path && $path === '/create-adyen-payment') {
        return $handler->handle($request);
    }
    if ($path && $path === '/create-nicky-payment') {
        return $handler->handle($request);
    }
    if ($path && $path === '/create-crypto-payment') {
        return $handler->handle($request);
    }
    if ($path && $path === '/clear-cache') {
        return $handler->handle($request);
    }
    if ($path && $path === '/token-well') {
        $csrf->generateToken();
        return $handler->handle($request);
    }

    // If not skipped, apply the CSRF Guard
    return $csrf->process($request, $handler);
};

$app->add($csrfMiddleware);
$app->setBasePath(routePath());

require __DIR__ . '/../routes/web.php';