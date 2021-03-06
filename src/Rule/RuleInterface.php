<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;

interface RuleInterface
{
    public function onRequest(Request $request): void;
    public function onConfirm(Request $request): void;
}