<?php

namespace Domain\User\Entity;

use Domain\User\Event\UserSignedUp;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

class User implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;

    /** @var UserId */
    private $id;

    /** @var Email */
    private $email;

    /** @var FullName */
    private $fullName;

    /** @var Password */
    private $password;

    /** @var \DateTime */
    private $createdAt;

    public function __construct(UserId $id, Email $email, FullName $fullName, PasswordHash $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->createdAt = new \DateTime();

        $this->record(new UserSignedUp($this->id));
    }

    /** @return UserId */
    public function getId()
    {
        return $this->id;
    }

    /** @return Email */
    public function getEmail()
    {
        return $this->email;
    }

    /** @return FullName */
    public function getFullName()
    {
        return $this->fullName;
    }

    /** @return Password */
    public function getPassword()
    {
        return $this->password;
    }

    /** @return \DateTime */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
