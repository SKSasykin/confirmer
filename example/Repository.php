<?php

declare(strict_types=1);

use Confirmer\Entity\Request;
use Confirmer\Exception\NotFoundException;
use Confirmer\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $db = [];

    public function save(Request $request): void
    {
        $this->db[$request->getRecipient()] = $request;
    }

    public function getByRecipient(string $recipient): Request
    {
        $result = $this->db[$recipient] ?? null;

        if(!$result) {
            throw new NotFoundException();
        }

        return $result;
    }

    public function getByToken(string $token): Request
    {
        throw new NotFoundException();
    }

    public function findByIp(string $ip): array
    {
        throw new NotFoundException();
    }
}