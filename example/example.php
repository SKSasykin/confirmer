<?php

declare(strict_types=1);

use Confirmer\CodeGenerator\Code;
use Confirmer\Confirmer;
use Confirmer\Entity\Message;
use Confirmer\Entity\Request;
use Confirmer\Entity\Status;
use Confirmer\Exception\InvalidCodeException;
use Confirmer\Exception\NotExpiredException;
use Confirmer\Exception\TriesLimitException;
use Confirmer\Rule\DayLimit;
use Confirmer\Rule\ExpireLimit;
use Confirmer\Rule\RepeatLimit;
use Confirmer\Rule\TriesLimit;

require "../vendor/autoload.php";
require "Repository.php";
require "Command.php";

$request = new Request('711111', '127.0.0.1', '', new Status(new Code('123')));
$message = new Message('sms body code: #(code)');

$repository = new Repository();
$command    = new Command();

$smsConfirmation = new Confirmer($repository, $command, $request, $message);
$smsConfirmation->addRule(new RepeatLimit(2));
//$smsConfirmation->addRule(new DayLimit(1));
$smsConfirmation->addRule(new TriesLimit(1));
$smsConfirmation->addRule(new ExpireLimit(600));

echo "request1:\n";
$smsConfirmation->request();

echo "confirm:\n";
try {
    $smsConfirmation->confirm('1234');
} catch (InvalidCodeException $exception) {
    echo "- catch InvalidCodeException\n";
}

echo "confirm:\n";
try {
    $smsConfirmation->confirm('1234');
} catch (TriesLimitException $exception) {
    echo "- catch TriesLimitException\n";
} catch (InvalidCodeException $exception) {
    echo "- catch InvalidCodeException\n";
}

echo "request2:\n";
try {
    $smsConfirmation->request();
} catch (NotExpiredException $exception){
    echo "- catch NotExpiredException\n";
}

sleep(3);

echo "request3:\n";
$smsConfirmation->request();

echo "confirm:\n";
$smsConfirmation->confirm('123');
echo "+ success\n";

echo "done\n";
