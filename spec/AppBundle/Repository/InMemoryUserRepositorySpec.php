<?php

namespace spec\AppBundle\Repository;

use Domain\Core\Identity\Uuid;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryUserRepositorySpec extends ObjectBehavior
{
    const UUID          = '5399dbab-ccd0-493c-be1a-67300de1671f';
    const EXISTING_UUID = '8ce05088-ed1f-43e9-a415-3b3792655a9b';
    const EMAIL         = 'virgil@mundell.com';
    const FULLNAME      = 'Virgil Mundell';

    /** @var User */
    private $existingUser;

    /** @var User */
    private $user;

    function let()
    {
        $this->existingUser = new User(
            new UserId(new Uuid(self::EXISTING_UUID)),
            new Email('john@doe.com'),
            new FullName('John Doe')
        );

        $this->user = new User(
            new UserId(new Uuid(self::UUID)),
            new Email(self::EMAIL),
            new FullName(self::FULLNAME)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Repository\InMemoryUserRepository');
    }

    function it_throws_an_exception_if_user_not_found()
    {
        $userId = new UserId(new Uuid(self::UUID));

        $this->shouldThrow(UserNotFoundException::CLASS)->during('findByUserId', [$userId]);
    }

    function it_finds_a_user_by_id()
    {
        $userId = new UserId(new Uuid(self::EXISTING_UUID));

        $this->findByUserId($userId)->shouldBeLike($this->existingUser);
    }

    function it_adds_a_user()
    {
        $this->add($this->user);

        $this->findByUserId($this->user->getId())->shouldReturn($this->user);
    }
}
