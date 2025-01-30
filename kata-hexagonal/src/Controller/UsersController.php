<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\UserRegisterService;
use App\Domain\Repositories\UserRepository;
use App\Application\dtos\UserRegisterRequest;
use Cake\Http\Response;
use Cake\View\JsonView;
use Exception;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->addViewClasses([JsonView::class]);
    }

    public function register(UserRegisterService $service): ?Response
    {
        if ($this->request->is('post')) {
            try {
                $request = new UserRegisterRequest($this->request->getData('email'), $this->request->getData('password'));

                $response = $service->register($request);

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            } catch (Exception $e) {
                return $this->response
                    ->withStatus(400)
                    ->withStringBody(json_encode(['message' => $e->getMessage()]));
            }
        }
        return $this->response
            ->withStatus(405) // Method Not Allowed
            ->withStringBody(json_encode(['error' => 'Method not allowed']));
    }
}
