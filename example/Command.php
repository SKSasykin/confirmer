<?php

declare(strict_types=1);

use Confirmer\CommandInterface;
use Confirmer\Entity\Message;
use Confirmer\Entity\Request;

class Command implements CommandInterface
{
    public function execute(Request $request, Message $message)
    {
        echo "+ Run command for {$request->getRecipient()} \n";
    }
}