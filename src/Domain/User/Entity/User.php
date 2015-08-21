<?php

namespace Domain\User\Entity;

use Domain\User\Event\UserWasEntered;
use Domain\User\Value\Email;
use Domain\User\Value\FullName;
use Domain\User\Value\PasswordHash;
use Domain\User\Value\UserId;
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

        $this->record(new UserWasEntered($this->id));
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
