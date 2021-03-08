<?php

declare(strict_types=1);

namespace Confirmer;

use Confirmer\Entity\Request;

interface RepositoryInterface
{
    public function save(Request $request): void;
}