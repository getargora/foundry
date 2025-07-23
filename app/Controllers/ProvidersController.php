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
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $db = $this->container->get('db');

            $name = trim(filter_var($data['name'] ?? '', FILTER_SANITIZE_STRING));
            $type = in_array($data['type'] ?? '', ['domain', 'hosting', 'email', 'api', 'custom']) ? $data['type'] : 'custom';

            $api_connection = trim(filter_var($data['api_connection'] ?? '', FILTER_SANITIZE_URL));

            $credentials_raw = $data['credentials'] ?? '{}';
            $credentials = json_decode($credentials_raw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->container->get('flash')->addMessage('error', 'Invalid JSON in credentials');
                return $response->withHeader('Location', '/provider/create')->withStatus(302);
            }
            $credentials = json_encode($credentials);

            $status = in_array($data['status'] ?? '', ['active', 'inactive', 'testing']) ? $data['status'] : 'active';

            try {
                $currentDateTime = new \DateTime();
                $created_at = $currentDateTime->format('Y-m-d H:i:s.v');
                $db->insert(
                    'providers',
                    [
                        'name' => $name,
                        'type' => $type,
                        'api_endpoint' => $api_connection,
                        'credentials' => $credentials,
                        'status' => $status,
                        'created_at' => $created_at
                    ]
                );
            } catch (Exception $e) {
                $this->container->get('flash')->addMessage('error', 'Database failure: ' . $e->getMessage());
                return $response->withHeader('Location', '/provider/create')->withStatus(302);
            }

            $this->container->get('flash')->addMessage('success', 'Provider ' . $name . ' has been created successfully on ' . $created_at);
            return $response->withHeader('Location', '/providers')->withStatus(302);
        }

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