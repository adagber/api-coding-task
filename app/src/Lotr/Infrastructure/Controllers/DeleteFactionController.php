<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\DeleteFactionDto;
use App\Lotr\Application\Exceptions\FactionNotFoundException;
use App\Lotr\Application\Services\FactionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class DeleteFactionController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = DeleteFactionDto::create($args['id']);
        $service = $this->container->get(FactionService::class);

        try {
            $service->delete($dto);
        } catch (FactionNotFoundException $exc){

            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $response->withStatus(204);
    }
}