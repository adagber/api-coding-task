<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Controllers;

use App\Lotr\Infrastructure\Controllers\AbstractController;
use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use App\Security\Application\DTO\LoginDto;
use App\Security\Application\Exceptions\UserNotFoundException;
use App\Security\Application\Services\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

final class LoginUserController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $dto = LoginDto::createFromArray($request->getParsedBody());
        $validator = $this->container->get(ValidatorInterface::class);
        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            return $this->createInvalidDataResponse($errors, $response);
        }

        $service = $this->container->get(UserService::class);

        try {
            $token = $service->login($dto);
        } catch (UserNotFoundException $exc){

            throw new HttpBadRequestException($request, 'Bad credentials');
        }

        return $this->createJsonResponse([
            'token' => $token
        ], $response);
    }
}