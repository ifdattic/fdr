<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\User\Repository\UserRepository;

class ApiContext implements Context, SnippetAcceptingContext
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @BeforeScenario
     */
    public function before()
    {
        $this->userRepository->clear();
    }
}
