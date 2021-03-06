<?php

declare(strict_types=1);

use Confirmer\Entity\Request;
use Confirmer\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $db = [];

    public function save(Request $request): void
    {
        $this->db[$request->getRecipient()] = $request;
    }

    /**
     * @inheritDoc
     */
    public function findByRecipient(string $recipient): array
    {
        $result = $this->db[$recipient] ?? null;

        return $result ? [$result] : [];
    }
}