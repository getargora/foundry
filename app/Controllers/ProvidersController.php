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

use App\Models\Providers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class ProvidersController extends Controller
{
    public function listProviders(Request $request, Response $response): Response
    {
        return view($response, 'admin/providers/index.twig');
    }

    public function viewProvider(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/providers/view.twig', ['id' => $args['id'] ?? null]);
    }

    public function createProvider(Request $request, Response $response): Response
    {
        return view($response, 'admin/providers/create.twig');
    }

    public function editProvider(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/providers/edit.twig', ['id' => $args['id'] ?? null]);
    }

    public function deleteProvider(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/providers/delete.twig', ['id' => $args['id'] ?? null]);
    }
}