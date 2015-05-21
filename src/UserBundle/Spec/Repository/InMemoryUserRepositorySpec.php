<?php

namespace Spec\UserBundle\Repository;

use Domain\Core\Identity\Uuid;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryUserRepositorySpec extends ObjectBehavior
{
    const EMAIL          = 'virgil@mundell.com';
    const EXISTING_EMAIL = 'john@doe.com';
    const EXISTING_UUID  = '8ce05088-ed1f-43e9-a415-3b3792655a9b';
    const FULLNAME       = 'Virgil Mundell';
    const UUID           = '5399dbab-ccd0-493c-be1a-67300de1671f';

    /** @var User */
    private $existingUser;

    /** @var User */
    private $user;

    function let()
    {
        $this->existingUser = new User(
            new UserId(new Uuid(self::EXISTING_UUID)),
            new Email(self::EXISTING_EMAIL),
            new FullName('John Doe'),
            new PasswordHash('$2y$04$ZpNmuQAE0roOG.UnpEFErOuZ0fFMXmMDoojuzmbvOwhYOKT9SJgB2')
        );

        $this->user = new User(
            new UserId(new Uuid(self::UUID)),
            new Email(self::EMAIL),
            new FullName(self::FULLNAME),
            new PasswordHash('$2y$04$dWGqp58K1Xjr5tJUX/5TjOgWUBqC9EnPS8/sLog35cC46FJZh20QW')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UserBundle\Repository\InMemoryUserRepository');
    }

    function it_throws_an_exception_if_user_not_found()
    {
        $userId = new UserId(new Uuid(self::UUID));

        $this->shouldThrow(UserNotFoundException::CLASS)->during('findByUserId', [$userId]);
    }

    function it_finds_a_user_by_id()
    {
        $userId = new UserId(new Uuid(self::EXISTING_UUID));

        $this->add($this->existingUser);

        $this->findByUserId($userId)->shouldBeLike($this->existingUser);
    }

    function it_adds_a_user()
    {
        $this->add($this->user);

        $this->findByUserId($this->user->getId())->shouldReturn($this->user);
    }

    function it_returns_false_when_checking_for_unique_email_when_email_is_taken()
    {
        $email = new Email(self::EXISTING_EMAIL);

        $this->add($this->existingUser);

        $this->isEmailUnique($email)->shouldReturn(false);
    }

    function it_returns_true_when_checking_for_unique_email_when_email_is_not_taken()
    {
        $email = new Email(self::EMAIL);

        $this->add($this->existingUser);

        $this->isEmailUnique($email)->shouldReturn(true);
    }
}
