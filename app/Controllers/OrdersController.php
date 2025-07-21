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

use App\Models\Orders;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class OrdersController extends Controller
{
    public function listOrders(Request $request, Response $response): Response
    {
        return view($response, 'admin/orders/index.twig');
    }

    public function viewOrder(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/orders/view.twig', ['id' => $args['id'] ?? null]);
    }

    public function createOrder(Request $request, Response $response): Response
    {
        return view($response, 'admin/orders/create.twig');
    }

    public function editOrder(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/orders/edit.twig', ['id' => $args['id'] ?? null]);
    }

    public function deleteOrder(Request $request, Response $response, array $args): Response
    {
        return view($response, 'admin/orders/delete.twig', ['id' => $args['id'] ?? null]);
    }
}