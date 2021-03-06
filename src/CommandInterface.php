<?php

declare(strict_types=1);

namespace Confirmer;

use Confirmer\Entity\Message;
use Confirmer\Entity\Request;

interface CommandInterface
{
    public function execute(Request $request, Message $message);
}