<?php

namespace TaskBundle\Features\Context;

use AppBundle\Features\Context\ApiContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use PHPUnit_Framework_Assert as Assert;
use UserBundle\Features\Context\UserApiContext;

class TaskApiContext implements Context, SnippetAcceptingContext
{
    const COMPLETED_DATE = '2015-04-15 13:14:15';
    const DATE           = '2015-04-15';
    const DATE2          = '2014-06-05';
    const DESCRIPTION    = 'This is the description.';
    const ESTIMATED      = 3;
    const IMPORTANT      = true;
    const TASK_NAME      = 'Task Name';
    const TASK_NAME2     = 'Task Name Alternative';
    const TIME_SPENT     = 23;
    const UUID           = '5399dbab-ccd0-493c-be1a-67300de1671f';
    const UUID2          = '97fd781e-35c5-4b8e-9175-3ae730d86bdb';
    const UUID3          = 'df603d36-1203-4bc5-9cd8-99c775ac272a';

    /** @var ApiContext */
    private $apiContext;

    /** @var TaskRepository */
    private $taskRepository;

    /** @var UserApiContext */
    private $userApiContext;

    /** @var Task[] */
    private $tasks;

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

        $this->apiContext = $environment->getContext(ApiContext::CLASS);
        $this->userApiContext = $environment->getContext(UserApiContext::CLASS);

        $this->taskRepository->clear();

        $this->tasks = [];
    }

    /**
     * @Given task data is seeded
     */
    public function taskDataIsSeeded()
    {
        $task = new Task(
            TaskId::createFromString(self::UUID),
            $this->userApiContext->getUsers()[UserApiContext::UUID],
            new TaskName(self::TASK_NAME),
            new \DateTime(self::DATE)
        );
        $task->setDescription(new Description(self::DESCRIPTION));
        $task->setEstimated(new Estimated(self::ESTIMATED));
        $task->setCompletedAt(new \DateTime(self::COMPLETED_DATE));
        $task->setTimeSpent(new TimeSpent(self::TIME_SPENT));
        $task->setImportant(self::IMPORTANT);

        $this->tasks[self::UUID] = $task;

        $task = new Task(
            TaskId::createFromString(self::UUID2),
            $this->userApiContext->getUsers()[UserApiContext::UUID2],
            new TaskName(self::TASK_NAME2),
            new \DateTime(self::DATE2)
        );
        $this->tasks[self::UUID2] = $task;

        $task = new Task(
            TaskId::createFromString(self::UUID3),
            $this->userApiContext->getUsers()[UserApiContext::UUID],
            new TaskName(self::TASK_NAME2),
            new \DateTime(self::DATE2)
        );
        $this->tasks[self::UUID3] = $task;

        foreach ($this->tasks as $task) {
            $this->taskRepository->add($task);
        }
    }

    /** @return Task[] */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Get task as array for response comparison.
     *
     * @param  Task   $task
     * @return array
     */
    private function getTaskAsArray(Task $task)
    {
        return [
            'id' => $task->getId()->getValue(),
            'name' => $task->getName()->getValue(),
            'date' => $task->getDate()->format('Y-m-d'),
            'description' => $task->getDescription()->getValue(),
            'estimated' => $task->getEstimated()->getValue(),
            'completed' => $task->isCompleted(),
            'completed_at' => $task->isCompleted()
                ? $task->getCompletedAt()->format(\DateTime::ISO8601)
                : $task->getCompletedAt(),
            'time_spent' => $task->getTimeSpent()->getValue(),
            'important' => $task->isImportant(),
            'created_at' => $task->getCreatedAt()->format(\DateTime::ISO8601),
        ];
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

        $this->apiContext->compareResponse([], ['code', 'message']);
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
                'important' => self::IMPORTANT,
            ],
        ];

        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iCreateTaskWithPayload(json_encode($payload));

        $this->apiContext->iShouldReceiveCreatedResponse();

        $this->apiContext->compareResponse([], [
            'message',
            'task.id',
            'task.name',
            'task.date',
            'task.description',
            'task.estimated',
            'task.completed',
            'task.completed_at',
            'task.time_spent',
            'task.important',
            'task.created_at',
            'task',
        ]);
    }

    /**
     * @When I get task with id :id
     */
    public function iGetTaskWithId($id)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'GET',
            $this->apiContext->locatePath('/tasks/'.$id),
            [],
            [],
            ['HTTP_AUTHORIZATION' => $this->userApiContext->getAuthToken()],
            []
        );
    }

    /**
     * @Then I should not see a task which doesn't exist
     */
    public function iShouldNotSeeATaskWhichDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(self::UUID);

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should not be able to see a task I don't own
     */
    public function iShouldNotBeAbleToSeeATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(self::UUID2);

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should see details of task I own
     */
    public function iShouldSeeDetailsOfTaskIOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(self::UUID);

        $this->apiContext->iShouldReceiveSuccessResponse();

        $task = $this->getTasks()[self::UUID];
        $expected = [
            'task' => $this->getTaskAsArray($task),
        ];

        $this->apiContext->compareResponse($expected);
    }

    /**
     * @When I get tasks
     */
    public function iGetTasks()
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'GET',
            $this->apiContext->locatePath('/tasks'),
            [],
            [],
            ['HTTP_AUTHORIZATION' => $this->userApiContext->getAuthToken()],
            []
        );
    }

    /**
     * @Then I should not get any tasks if I don't have them
     */
    public function iShouldNotGetAnyTasksIfIDontHaveThem()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTasks();

        $this->apiContext->iShouldReceiveSuccessResponse();

        $expected = ['tasks' => []];

        $this->apiContext->compareResponse($expected);
    }

    /**
     * @Then I should get a list of my tasks
     */
    public function iShouldGetAListOfMyTasks()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTasks();

        $this->apiContext->iShouldReceiveSuccessResponse();

        $expected = ['tasks' => [
            $this->getTaskAsArray($this->getTasks()[self::UUID]),
            $this->getTaskAsArray($this->getTasks()[self::UUID3]),
        ]];

        $this->apiContext->compareResponse($expected);
    }

    /**
     * @When I delete task with id :id
     */
    public function iDeleteTaskWithId($id)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'DELETE',
            $this->apiContext->locatePath('/tasks/'.$id),
            [],
            [],
            ['HTTP_AUTHORIZATION' => $this->userApiContext->getAuthToken()],
            []
        );
    }

    /**
     * @Then I should not be able to delete a task which doesn't exist
     */
    public function iShouldNotBeAbleToDeleteATaskWhichDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(self::UUID);

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should not be able to delete a task I don't own
     */
    public function iShouldNotBeAbleToDeleteATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(self::UUID2);

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should be able to delete a task
     */
    public function iShouldBeAbleToDeleteATask()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(self::UUID);

        $this->apiContext->iShouldReceiveSuccessResponse();

        $this->apiContext->compareResponse([]);
    }

    /**
     * @When I update task :id with payload :payload
     */
    public function iUpdateTaskWithPayload($id, $payload)
    {
        $client = $this->apiContext->getSession()->getDriver()->getClient();

        $client->request(
            'PUT',
            $this->apiContext->locatePath('/tasks/'.$id),
            [],
            [],
            ['HTTP_AUTHORIZATION' => $this->userApiContext->getAuthToken()],
            $payload
        );
    }

    /**
     * @Then I should not be able to update a task without an account
     */
    public function iShouldNotBeAbleToUpdateATaskWithoutAnAccount()
    {
        $this->iUpdateTaskWithPayload(self::UUID, '{}');

        $this->apiContext->iShouldReceiveUnauthorizedResponse();

        $this->apiContext->compareResponse([], ['code', 'message']);
    }

    /**
     * @Then I should not be able to update a task if it doesn't exist
     */
    public function iShouldNotBeAbleToUpdateATaskIfItDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(self::UUID, '{}');

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should not be able to update a task I don't own
     */
    public function iShouldNotBeAbleToUpdateATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(self::UUID2, '{}');

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['code', 'message', 'errors']);
    }

    /**
     * @Then I should update a task I own
     */
    public function iShouldUpdateATaskIOwn()
    {
        $payload = [
            'update_task' => [
                'name' => self::TASK_NAME2,
                'date' => self::DATE2,
                'description' => self::DESCRIPTION,
                'estimated' => self::ESTIMATED,
                'completed_at' => self::COMPLETED_DATE,
                'time_spent' => self::TIME_SPENT,
                'important' => self::IMPORTANT,
            ],
        ];

        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(self::UUID, json_encode($payload));

        $this->apiContext->iShouldReceiveSuccessResponse();

        $expected = [
            'task' => [
                'name' => self::TASK_NAME2,
                'date' => self::DATE2,
                'description' => self::DESCRIPTION,
            ],
        ];

        $this->apiContext->compareResponse($expected, [
            'message',
            'task.id',
            'task.estimated',
            'task.completed',
            'task.completed_at',
            'task.time_spent',
            'task.important',
            'task.created_at',
        ]);
    }

}
