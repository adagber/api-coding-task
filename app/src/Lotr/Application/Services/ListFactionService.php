<?php declare(strict_types=1);

namespace App\Lotr\Application\Services;

use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Domain\Model\FactionRepositoryInterface;

final class ListFactionService
{

    public function __construct(
        private FactionRepositoryInterface $repository
    )
    {
    }

    public function __invoke(ListFactionDto $dto): array
    {
        return $this->repository->findAll();
    }
}