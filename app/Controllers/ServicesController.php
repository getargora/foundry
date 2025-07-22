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

namespace App\Controllers;

use App\Models\Services;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class ServicesController extends Controller
{
    public function listServices(Request $request, Response $response): Response
    {
        return view($response, 'admin/services/index.twig');
    }

    public function viewService(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/services/view.twig', ['id' => $args['id'] ?? null]);
    }

    public function editService(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/services/edit.twig', ['id' => $args['id'] ?? null]);
    }

    public function serviceLogs(Request $request, Response $response): Response
    {
        return view($response, 'admin/services/logs.twig');
    }
}