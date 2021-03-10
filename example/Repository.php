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

// --Commented out by Inspection START (10.03.2021, 23:23):
//    public function findByRecipient(string $recipient): array
//    {
//        $result = $this->db[$recipient] ?? null;
//
//        return $result ? [$result] : [];
//    }
// --Commented out by Inspection STOP (10.03.2021, 23:23)

}