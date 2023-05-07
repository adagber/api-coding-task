<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\ShowFactionDto;
use App\Lotr\Application\Services\FactionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class ShowFactionController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = ShowFactionDto::create($args['id']);
        $service = $this->container->get(FactionService::class);
        $faction = $service->show($dto);
        if(!$faction){
            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $this->createJsonResponse($faction, $response);
    }
}