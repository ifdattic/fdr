<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Core\Identity\Uuid;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PHPUnit_Framework_Assert as Assert;

class ApiContext implements Context, SnippetAcceptingContext
{
    const AVAILABLE_EMAIL = 'john@doe.com';
    const PASSWORD        = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';
    const UUID            = '5399dbab-ccd0-493c-be1a-67300de1671f';
    const EMAIL           = 'virgil@mundell.com';
    const FULLNAME        = 'Virgil Mundell';
    const PASSWORD_HASH   = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';

    /** @var UserRepository */
    private $userRepository;

    /** @var Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /** @var Behat\Mink\Session */
    private $session;

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

        $this->session = null;
    }

    /**
     * @Given data is seeded
     */
    public function dataIsSeeded()
    {
        $user = new User(
            new UserId(new Uuid(self::UUID)),
            new Email(self::EMAIL),
            new FullName(self::FULLNAME),
            new PasswordHash(self::PASSWORD_HASH)
        );

        $this->userRepository->add($user);
    }

    /**
     * @When I sign up with payload :payload
     */
    public function iSignUpWithPayload($payload)
    {
        $this->session = $this->minkContext->getSession();
        $client = $this->session->getDriver()->getClient();

        $client->request('POST', $this->minkContext->locatePath('/users'), [], [], [], $payload);
    }

    /**
     * @When I sign up with available email
     */
    public function iSignUpWithAvailableEmail()
    {
        $payload = [
            'sign_up' => [
                'email' => self::AVAILABLE_EMAIL,
                'full_name' => 'name',
                'password' => self::PASSWORD,
            ],
        ];

        $this->iSignUpWithPayload(json_encode($payload));
    }

    /**
     * @When I sign up with email which is taken
     */
    public function iSignUpWithEmailWhichIsTaken()
    {
        $payload = [
            'sign_up' => [
                'email' => self::EMAIL,
                'full_name' => 'name',
                'password' => self::PASSWORD,
            ],
        ];

        $this->iSignUpWithPayload(json_encode($payload));
    }

    /**
     * @Then I should receive created response
     */
    public function iShouldReceiveCreatedResponse()
    {
        Assert::assertSame(201, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive bad request response
     */
    public function iShouldReceiveBadRequestResponse()
    {
        Assert::assertSame(400, $this->session->getStatusCode());
    }

    /**
     * @Then I should be able to log in as newly created user
     */
    public function iShouldBeAbleToLogInAsNewlyCreatedUser()
    {
        throw new PendingException();
    }

    /**
     * @When I get response content
     */
    public function iGetResponseContent()
    {
        echo $this->session->getPage()->getContent();
    }
}
