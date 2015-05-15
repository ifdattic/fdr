<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\User\Repository\UserRepository;
use PHPUnit_Framework_Assert as Assert;

class ApiContext implements Context, SnippetAcceptingContext
{
    /** @var UserRepository */
    private $userRepository;

    /** @var Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');

        $this->userRepository->clear();
    }

    /**
     * @When I sign up with email :email, full name :fullName and password :password
     */
    public function iSignUpWithEmailFullNameAndPassword($email, $fullName, $password)
    {
        $body = [
            'email' => $email,
            'fullName' => $fullName,
            'password' => $password,
        ];
        $session = $this->minkContext->getSession();
        $client = $session->getDriver()->getClient();

        $response = $client->request('POST', $this->minkContext->locatePath('/users'), [], [], [], json_encode($body));

        Assert::assertSame(201, $session->getStatusCode());
    }

    /**
     * @Then I should be able to log in with email :email and password :password
     */
    public function iShouldBeAbleToLogInWithEmailAndPassword($email, $password)
    {
        throw new PendingException();
    }
}
