<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\Exceptions\FactionNotFoundException;
use App\Lotr\Application\Services\FactionService;
use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class UpdateFactionController extends AbstractController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = CreateFactionDto::createFromArray($request->getParsedBody());
        $validator = $this->container->get(ValidatorInterface::class);
        $errors = $validator->validate($dto, ['update']);

        if (count($errors) > 0) {
            return $this->createInvalidDataResponse($errors, $response);
        }

        $service = $this->container->get(FactionService::class);

        try {
            $service->update($args['id'], $dto);
        } catch (FactionNotFoundException $exc){

            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $response->withStatus(204);
    }
}