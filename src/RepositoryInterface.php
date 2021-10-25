<?php

declare(strict_types=1);

namespace Confirmer;

use Confirmer\Entity\Request;
use Confirmer\Exception\NotFoundException;

interface RepositoryInterface
{
    public function save(Request $request): void;

    /**
     * @param string $recipient
     * @return Request
     * @throws NotFoundException
     */
    public function getByRecipient(string $recipient): Request;

    /**
     * @param string $token
     * @return Request
     * @throws NotFoundException
     */
    public function getByToken(string $token): Request;

    /**
     * @param string $ip
     * @return Request[]
     */
    public function findByIp(string $ip): array;
}