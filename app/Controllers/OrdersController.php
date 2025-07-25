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
        $db = $this->container->get('db');
        $providers = $db->select("SELECT id, name, type, api_endpoint, credentials, pricing FROM providers WHERE status = 'active'");

        foreach ($providers as &$provider) {
            $rawProducts = json_decode($provider['pricing'], true) ?? [];
            $enrichedProducts = [];

            foreach ($rawProducts as $tld => $actions) {
                $enrichedProducts[$tld] = $actions;
                $enrichedProducts[$tld]['type'] = 'domain';
                $enrichedProducts[$tld]['label'] = $tld;
                $enrichedProducts[$tld]['description'] = 'Domain services for ' . $tld;
                $enrichedProducts[$tld]['price'] = $actions['register']['1'] ?? 0;
                $enrichedProducts[$tld]['billing'] = 'year';
                $enrichedProducts[$tld]['fields'] = [];
            }

            $provider['products'] = $enrichedProducts;
        }

        return $this->container->get('view')->render($response, 'admin/orders/create.twig', [
            'providers' => $providers,
            'user' => $_SESSION['auth_user_id'] ?? null
        ]);
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