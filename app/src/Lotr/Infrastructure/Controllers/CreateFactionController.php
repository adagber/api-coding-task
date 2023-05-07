<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;


use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\Services\FactionService;
use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateFactionController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = CreateFactionDto::createFromArray($request->getParsedBody());
        $validator = $this->container->get(ValidatorInterface::class);
        $errors = $validator->validate($dto, ['create']);

        if (count($errors) > 0) {
            return $this->createInvalidDataResponse($errors, $response);
        }

        $service = $this->container->get(FactionService::class);
        $faction = $service->create($dto);

        return $this->createJsonResponse($faction, $response, 201);
    }
}