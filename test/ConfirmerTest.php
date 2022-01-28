<?php

declare(strict_types=1);

namespace Confirmer;

use Confirmer\CodeGenerator\Code;
use Confirmer\Entity\Message;
use Confirmer\Entity\Request;
use Confirmer\Entity\Status;
use Confirmer\Exception\InvalidCodeException;
use Confirmer\Rule\RuleInterface;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class ConfirmerTest extends TestCase
{
    /**
     * @var Repository
     */
    private $repository;
    /**
     * @var Command
     */
    private $command;
    /**
     * @var Request
     */
    private $request;

    protected function setUp(): void
    {
        $this->repository = new Repository();
        $this->command    = new Command();
        $this->request    = new Request('711111', '127.0.0.1', 'token', new Status(new Code('1234')));
    }

    public function testConstruct()
    {
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);

        self::assertEquals($this->repository, $this->privateAccessValue($confirmer, 'repository'));
        self::assertEquals($this->command, $this->privateAccessValue($confirmer, 'command'));
        self::assertEquals($this->request, $this->privateAccessValue($confirmer, 'request'));

        self::assertEquals(Message::class, get_class($this->privateAccessValue($confirmer, 'message')));
    }

    public function testAddRule()
    {
        $rule      = new Rule();
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);

        self::assertEquals([], $this->privateAccessValue($confirmer, 'rules'));

        $confirmer->addRule($rule);
        self::assertEquals([$rule], $this->privateAccessValue($confirmer, 'rules'));
    }

    public function testRequestNoRules()
    {
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);
        /** @var Message $message */
        $message = $this->privateAccessValue($confirmer, 'message');

        self::assertEquals('', $message->getParam('code'));

        $confirmer->request();

        self::assertEquals('1234', $message->getParam('code'));
        self::assertNotNull($this->command->getExecuteResult());
        self::assertNotNull($this->repository->getSaveResult());
    }

    public function testRequestWithCode()
    {
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);

        $confirmer->request('4444');

        /** @var Message $message */
        [, $message] = $this->command->getExecuteResult();

        self::assertEquals('4444', $message->getParam('code'));
    }

    public function testRequestWithRule()
    {
        $rule      = new Rule();
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);
        $confirmer->addRule($rule);

        $confirmer->request();

        self::assertNotNull($rule->getOnRequestResult());
    }

    public function testConfirmInvalidCode()
    {
        $this->expectException(InvalidCodeException::class);

        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);

        $confirmer->confirm('4444');

        self::assertNotNull($this->repository->getSaveResult());
    }

    public function testConfirmNoRules()
    {
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);

        self::assertFalse($this->request->getStatus()->isConfirmed());

        $confirmer->confirm('1234');

        self::assertTrue($this->request->getStatus()->isConfirmed());
        self::assertTrue($this->repository->getSaveResult()->getStatus()->isConfirmed());
    }

    public function testConfirmWithRule()
    {
        $rule      = new Rule();
        $confirmer = new Confirmer($this->repository, $this->command, null, $this->request);
        $confirmer->addRule($rule);

        $confirmer->confirm('1234');

        self::assertNotNull($rule->getOnConfirmResult());
    }

    private function privateAccessValue(object $object, string $field)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $repository = new ReflectionProperty(get_class($object), $field);
        $repository->setAccessible(true);

        return $repository->getValue($object);
    }
}

class Repository implements RepositoryInterface
{
    private $saveResult;

    public function save(Request $request): void
    {
        $this->saveResult = $request;
    }

    public function getSaveResult(): ?Request
    {
        return $this->saveResult;
    }

    public function getByRecipient(string $recipient): Request
    {
        // TODO: Implement getByRecipient() method.
    }

    public function getByToken(string $token): Request
    {
        // TODO: Implement getByToken() method.
    }

    public function findByIp(string $ip): array
    {
        // TODO: Implement findByIp() method.
    }

}

class Command implements CommandInterface
{
    private $executeResult;

    public function execute(Request $request, Message $message): void
    {
        $this->executeResult = [$request, $message];
    }

    public function getExecuteResult(): ?array
    {
        return $this->executeResult;
    }
}

class Rule implements RuleInterface
{
    private $onRequestResult;
    private $onConfirmResult;

    public function onRequest(Request $request): void
    {
        $this->onRequestResult = $request;
    }

    public function onConfirm(Request $request): void
    {
        $this->onConfirmResult = $request;
    }

    public function getOnRequestResult(): ?Request
    {
        return $this->onRequestResult;
    }

    public function getOnConfirmResult(): ?Request
    {
        return $this->onConfirmResult;
    }
}