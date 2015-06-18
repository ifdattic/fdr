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
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PHPUnit_Framework_Assert as Assert;

class UserApiContext implements Context, SnippetAcceptingContext
{
    const AVAILABLE_EMAIL = 'john@doe.com';
    const EMAIL           = 'virgil@mundell.com';
    const EMAIL2          = 'alice@carlton.com';
    const FULLNAME        = 'Virgil Mundell';
    const FULLNAME2       = 'Alice Carlton';
    const PASSWORD        = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';
    const PASSWORD2       = '%XIIPqR2j*mEF^DNuQg1JIKXt2Dzej';
    const PASSWORD_HASH   = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';
    const PASSWORD_HASH2  = '$2y$14$WP8RXsprmipbMYe867YLmOEErWlZjlndcYijPT.swBodoHEdGWEU2';
    const UUID            = '5399dbab-ccd0-493c-be1a-67300de1671f';
    const UUID2           = '97fd781e-35c5-4b8e-9175-3ae730d86bdb';

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
            self::UUID => new User(
                new UserId(new Uuid(self::UUID)),
                new Email(self::EMAIL),
                new FullName(self::FULLNAME),
                new PasswordHash(self::PASSWORD_HASH)
            ),
            self::UUID2 => new User(
                new UserId(new Uuid(self::UUID2)),
                new Email(self::EMAIL2),
                new FullName(self::FULLNAME2),
                new PasswordHash(self::PASSWORD_HASH2)
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

        $client->request('POST', $this->apiContext->locatePath('/users/sign-up'), [], [], [], $payload);
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
     * @Then I log in with payload :payload
     */
    public function iLogInWithPayload($payload)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request('POST', $this->apiContext->locatePath('/users/get-token'), [], [], [], $payload);
    }

    /**
     * @Then I should be able to log in as newly created user
     */
    public function iShouldBeAbleToLogInAsNewlyCreatedUser()
    {
        $payload = [
            'email' => self::AVAILABLE_EMAIL,
            'password' => self::PASSWORD,
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
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveSuccessResponse();
        $this->iShouldReceiveAuthenticationToken();
    }

    /**
     * @Then I should not be able to log in with wrong password
     */
    public function iShouldNotBeAbleToLogInWithWrongPassword()
    {
        $payload = [
            'email' => self::EMAIL,
            'password' => self::PASSWORD2,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveUnauthorizedResponse();
    }

    /**
     * @Then I should not be able to log in with non existing account
     */
    public function iShouldNotBeAbleToLogInWithNonExistingAccount()
    {
        $payload = [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ];

        $this->iLogInWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveUnauthorizedResponse();
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
            ['HTTP_AUTHORIZATION' => $this->getAuthToken()],
            []
        );

        $this->apiContext->iShouldReceiveSuccessResponse();

        $response = $session->getPage()->getContent();
        $response = json_decode($response, true);

        $expectedResponse = [
            'user' => [
                'id' => self::UUID,
                'email' => self::EMAIL,
                'full_name' => self::FULLNAME,
            ],
        ];

        Assert::assertEquals($expectedResponse, $response);
    }
}
