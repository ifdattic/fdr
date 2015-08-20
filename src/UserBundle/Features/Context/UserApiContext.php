<?php

namespace UserBundle\Features\Context;

use AppBundle\Features\Context\ApiContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PHPUnit_Framework_Assert as Assert;

class UserApiContext implements Context, SnippetAcceptingContext
{
    /** @var UserRepository */
    private $userRepository;

    /** @var ApiContext */
    private $apiContext;

    /** @var string */
    private $authToken;

    /** @var User[] */
    private $users;

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

        $this->apiContext = $environment->getContext(ApiContext::CLASS);

        $this->userRepository->clear();

        $this->users = [];
    }

    /**
     * @Given user data is seeded
     */
    public function userDataIsSeeded()
    {
        $this->users = [
            TestValues::UUID => new User(
                new UserId(new Uuid(TestValues::UUID)),
                new Email(TestValues::EMAIL),
                new FullName(TestValues::FULLNAME),
                new PasswordHash(TestValues::PASSWORD_HASH)
            ),
            TestValues::UUID2 => new User(
                new UserId(new Uuid(TestValues::UUID2)),
                new Email(TestValues::EMAIL3),
                new FullName(TestValues::FULLNAME3),
                new PasswordHash(TestValues::PASSWORD_HASH2)
            ),
        ];

        foreach ($this->users as $user) {
            $this->userRepository->add($user);
        }
    }

    /** @return User[] */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get authentication token.
     *
     * @return string
     */
    public function getAuthToken()
    {
        return 'Bearer '.$this->authToken;
    }

    /**
     * @When I sign up with payload :payload
     */
    public function iSignUpWithPayload($payload)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'POST',
            $this->apiContext->locatePath('/users/sign-up'),
            [],
            [],
            $this->apiContext->getHeaders(),
            $payload
        );
    }

    /**
     * @When I sign up with available email
     */
    public function iSignUpWithAvailableEmail()
    {
        $payload = [
            'sign_up' => [
                'email' => TestValues::EMAIL2,
                'full_name' => 'name',
                'password' => TestValues::PASSWORD,
            ],
        ];

        $this->iSignUpWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveCreatedResponse();

        $this->apiContext->compareResponse([], ['message']);
    }

    /**
     * @When I sign up with email which is taken
     */
    public function iSignUpWithEmailWhichIsTaken()
    {
        $payload = [
            'sign_up' => [
                'email' => TestValues::EMAIL,
                'full_name' => 'name',
                'password' => TestValues::PASSWORD,
            ],
        ];

        $this->iSignUpWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveBadRequestResponse();

        $this->apiContext->compareResponse(
            [
                'errors' => [
                    ['field' => 'email'],
                ],
            ],
            [
                'errors.0.message',

                'errors.0.status_code',
                'errors.0.status_text',
            ]
        );
    }

    /**
     * @Then I log in with payload :payload
     */
    public function iLogInWithPayload($payload)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'POST',
            $this->apiContext->locatePath('/users/get-token'),
            [],
            [],
            $this->apiContext->getHeaders(),
            $payload
        );
    }

    /**
     * @Then I should be able to log in as newly created user
     */
    public function iShouldBeAbleToLogInAsNewlyCreatedUser()
    {
        $payload = [
            'email' => TestValues::EMAIL2,
            'password' => TestValues::PASSWORD,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveSuccessResponse();

        $this->iShouldReceiveAuthenticationToken();
    }

    /**
     * @Then I should be able to log in as existing user
     */
    public function iShouldBeAbleToLogInAsExistingUser()
    {
        $payload = [
            'email' => TestValues::EMAIL,
            'password' => TestValues::PASSWORD,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveSuccessResponse();

        $this->iShouldReceiveAuthenticationToken();

        $this->apiContext->compareResponse([], ['token']);
    }

    /**
     * @Then I should not be able to log in with wrong password
     */
    public function iShouldNotBeAbleToLogInWithWrongPassword()
    {
        $payload = [
            'email' => TestValues::EMAIL,
            'password' => TestValues::PASSWORD2,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveUnauthorizedResponse();

        $this->apiContext->compareResponse([], ['code', 'message']);
    }

    /**
     * @Then I should not be able to log in with non existing account
     */
    public function iShouldNotBeAbleToLogInWithNonExistingAccount()
    {
        $payload = [
            'email' => TestValues::EMAIL,
            'password' => TestValues::PASSWORD,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveUnauthorizedResponse();

        $this->apiContext->compareResponse([], ['code', 'message']);
    }

    /**
     * @Then I should receive authentication token
     */
    public function iShouldReceiveAuthenticationToken()
    {
        $response = $this->apiContext->getSession()->getPage()->getContent();
        $response = json_decode($response, true);

        Assert::assertArrayHasKey('token', $response, 'Response does not contain an authentication token!');

        $this->authToken = $response['token'];
    }

    /**
     * @Then I should see existing user data
     */
    public function iShouldSeeExistingUserData()
    {
        $session = $this->apiContext->getSession();
        $client = $session->getDriver()->getClient();

        $client->request(
            'GET',
            $this->apiContext->locatePath('/users/me'),
            [],
            [],
            $this->apiContext->getHeaders(true),
            []
        );

        $this->apiContext->iShouldReceiveSuccessResponse();

        $expected = [
            'user' => [
                'id' => TestValues::UUID,
                'email' => TestValues::EMAIL,
                'full_name' => TestValues::FULLNAME,
            ],
        ];

        $this->apiContext->compareResponse($expected);
    }
}
