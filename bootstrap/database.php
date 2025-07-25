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

use Pinga\Db\PdoDatabase;
use App\Lib\Logger;

$log = Logger::getInstance('Database');

// Load database config
$config = config('connections');
$defaultDriver = config('default') ?? 'mysql';

$supportedDrivers = [
    'mysql' => "{$config['mysql']['driver']}:dbname={$config['mysql']['database']};host={$config['mysql']['host']};charset={$config['mysql']['charset']}",
    'sqlite' => "{$config['sqlite']['driver']}:{$config['sqlite']['database']}",
    'pgsql' => "{$config['pgsql']['driver']}:dbname={$config['pgsql']['database']};host={$config['pgsql']['host']}"
];

$pdo = null;
$db = null;

try {
    // Select the correct database driver (fallback to MySQL)
    $driver = $supportedDrivers[$defaultDriver] ?? $supportedDrivers['mysql'];

    // Create PDO connection
    if (str_starts_with($driver, "sqlite")) {
        $pdo = new \PDO($driver);
    } else {
        $pdo = new \PDO($driver, $config[$defaultDriver]['username'], $config[$defaultDriver]['password']);
    }
    $db = PdoDatabase::fromPdo($pdo);

} catch (PDOException $e) {
    $log->alert("Database connection failed: " . $e->getMessage(), ['driver' => $defaultDriver]);
}

// Audit DB (optional)
/* try {
    $auditDriver = match ($defaultDriver) {
        'mysql' => "{$config['mysql']['driver']}:dbname=auditDBName;host={$config['mysql']['host']};charset={$config['mysql']['charset']}",
        'sqlite' => "{$config['sqlite']['driver']}:{$config['sqlite']['audit_path']}",
        'pgsql' => "{$config['pgsql']['driver']}:dbname=auditDBName;host={$config['pgsql']['host']}",
        default => throw new \RuntimeException('Unsupported database driver for audit'),
    };

    if (str_starts_with($auditDriver, "sqlite")) {
        $pdo_audit = new \PDO($auditDriver);
    } else {
        $pdo_audit = new \PDO(
            $auditDriver,
            $config[$defaultDriver]['username'],
            $config[$defaultDriver]['password']
        );
    }

    $db_audit = PdoDatabase::fromPdo($pdo_audit);
} catch (PDOException $e) {
    $log->alert("Audit database connection failed: " . $e->getMessage(), ['driver' => 'audit']);
} */