<?php

namespace TaskBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Task\Repository\TaskRepository;
use PHPUnit_Framework_Assert as Assert;

class TaskApiContext implements Context, SnippetAcceptingContext
{
    const DATE           = '2015-04-15';
    const DESCRIPTION    = 'This is the description.';
    const COMPLETED_DATE = '2015-04-15 13:14:15';
    const ESTIMATED      = 3;
    const TASK_NAME      = 'Task Name';
    const TIME_SPENT     = 23;
    const UUID           = '5399dbab-ccd0-493c-be1a-67300de1671f';

    /** @var ApiContext */
    private $apiContext;

    /** @var TaskRepository */
    private $taskRepository;

    /** @var UserApiContext */
    private $userApiContext;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->apiContext = $environment->getContext('AppBundle\Features\Context\ApiContext');
        $this->userApiContext = $environment->getContext('UserBundle\Features\Context\UserApiContext');

        $this->taskRepository->clear();
    }

    /**
     * @When I create task with payload :payload
     */
    public function iCreateTaskWithPayload($payload)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'POST',
            $this->apiContext->locatePath('/tasks'),
            [],
            [],
            ['HTTP_AUTHORIZATION' => $this->userApiContext->getAuthToken()],
            $payload
        );
    }

    /**
     * @Then I should not be able to create a task without an account
     */
    public function iShouldNotBeAbleToCreateATaskWithoutAnAccount()
    {
        $this->iCreateTaskWithPayload('{}');

        $this->apiContext->iShouldReceiveUnauthorizedResponse();
    }

    /**
     * @Then I should be able to create a task using existing account
     */
    public function iShouldBeAbleToCreateATaskUsingExistingAccount()
    {
        $payload = [
            'create_task' => [
                'name' => self::TASK_NAME,
                'date' => self::DATE,
                'description' => self::DESCRIPTION,
                'estimated' => self::ESTIMATED,
                'completed_at' => self::COMPLETED_DATE,
                'time_spent' => self::TIME_SPENT,
            ],
        ];

        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iCreateTaskWithPayload(json_encode($payload));
        $this->apiContext->iShouldReceiveCreatedResponse();

        $response = json_decode($this->apiContext->getResponseContent(), true);

        Assert::assertArrayHasKey('message', $response);
        Assert::assertArrayHasKey('task', $response);
    }
}
