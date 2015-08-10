<?php

namespace Spec\UserBundle\Repository;

use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UserBundle\Repository\InMemoryUserRepository;

class InMemoryUserRepositorySpec extends ObjectBehavior
{
    /** @var User */
    private $existingUser;

    /** @var User */
    private $user;

    function let()
    {
        $this->existingUser = new User(
            new UserId(new Uuid(TestValues::UUID2)),
            new Email(TestValues::EMAIL2),
            new FullName(TestValues::FULLNAME2),
            new PasswordHash(TestValues::PASSWORD_HASH2)
        );

        $this->user = new User(
            new UserId(new Uuid(TestValues::UUID)),
            new Email(TestValues::EMAIL),
            new FullName(TestValues::FULLNAME),
            new PasswordHash(TestValues::PASSWORD_HASH)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryUserRepository::CLASS);
    }

    function it_throws_an_exception_if_user_not_found()
    {
        $userId = new UserId(new Uuid(TestValues::UUID));

        $this->shouldThrow(UserNotFoundException::CLASS)->during('findByUserId', [$userId]);
    }

    function it_finds_a_user_by_id()
    {
        $userId = new UserId(new Uuid(TestValues::UUID2));

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
        $email = new Email(TestValues::EMAIL2);

        $this->add($this->existingUser);

        $this->isEmailUnique($email)->shouldReturn(false);
    }

    function it_returns_true_when_checking_for_unique_email_when_email_is_not_taken()
    {
        $email = new Email(TestValues::EMAIL);

        $this->add($this->existingUser);

        $this->isEmailUnique($email)->shouldReturn(true);
    }

    function it_throws_an_exception_if_user_with_provided_email_not_found()
    {
        $email = new Email(TestValues::EMAIL);

        $this->add($this->existingUser);

        $this->shouldThrow(UserNotFoundException::CLASS)->during('findByEmail', [$email]);
    }

    function it_returns_a_user_found_by_email()
    {
        $email = new Email(TestValues::EMAIL);

        $this->add($this->existingUser);
        $this->add($this->user);

        $this->findByEmail($email)->shouldReturn($this->user);
    }
}
