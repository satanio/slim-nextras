<?php declare(strict_types=1);

namespace App\Interface\Http\Controllers;

use App\Application\UseCases\CreateUserUseCase;
use App\Application\UseCases\GetUserUseCase;
use App\Application\UseCases\ListUsersUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends BaseController
{
    private ListUsersUseCase $listUsersUseCase;
    private GetUserUseCase $getUserUseCase;
    private CreateUserUseCase $createUserUseCase;
    
    public function __construct(
        ListUsersUseCase $listUsersUseCase,
        GetUserUseCase $getUserUseCase,
        CreateUserUseCase $createUserUseCase
    ) {
        $this->listUsersUseCase = $listUsersUseCase;
        $this->getUserUseCase = $getUserUseCase;
        $this->createUserUseCase = $createUserUseCase;
    }
    
    /**
     * List all users
     */
    public function index(Request $request, Response $response): Response
    {
        $users = $this->listUsersUseCase->execute();
        
		return $this->makeDataResponse($response, $users, 200);
    }
    
    /**
     * Get a single user by ID
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $args['id'];
        $user = $this->getUserUseCase->execute($userId);
        
        if ($user === null) {
			return $this->makeMessageResponse($response, 'User not found', 404);
        }
        
        return $this->makeDataResponse($response, $user->toArray(), 200);
    }
    
    /**
     * Create a new user
     */
    public function store(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);
        
        //TODO Symfony entity validator by sa hodil... v dalsej iteracii
        if (empty($data['name']) || empty($data['email'])) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Name and email are required',
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
        
        try {
            $user = $this->createUserUseCase->execute(
                $data['name'],
                $data['email']
            );
            
			return $this->makeDataResponse($response, $user->toArray(), 201);
        } catch (\Exception $e) {

			return $this->makeMessageResponse($response, 'Failed to create user: ' . $e->getMessage(), 500);
        }
    }
}

