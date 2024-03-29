<?php

namespace TaskBundle\Features\Context;

use AppBundle\Features\Context\ApiContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Core\Spec\TestValues;
use Domain\Core\Value\Description;
use Domain\Task\Entity\Task;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\Value\Estimate;
use Domain\Task\Value\TaskId;
use Domain\Task\Value\TaskName;
use Domain\Task\Value\TimeSpent;
use PHPUnit_Framework_Assert as Assert;
use UserBundle\Features\Context\UserApiContext;

class TaskApiContext implements Context, SnippetAcceptingContext
{
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
            TaskId::createFromString(TestValues::UUID),
            $this->userApiContext->getUsers()[TestValues::UUID],
            new TaskName(TestValues::TASK_NAME),
            new \DateTime(TestValues::DATE)
        );
        $task->updateDescription(new Description(TestValues::DESCRIPTION));
        $task->setInitialEstimate(new Estimate(TestValues::ESTIMATE));
        $task->complete(new \DateTime(TestValues::COMPLETED_DATE));
        $task->setInitialTimeSpent(new TimeSpent(TestValues::TIME_SPENT));
        $task->markAsImportant();

        $this->tasks[TestValues::UUID] = $task;

        $task = new Task(
            TaskId::createFromString(TestValues::UUID2),
            $this->userApiContext->getUsers()[TestValues::UUID2],
            new TaskName(TestValues::TASK_NAME2),
            new \DateTime(TestValues::DATE2)
        );
        $this->tasks[TestValues::UUID2] = $task;

        $task = new Task(
            TaskId::createFromString(TestValues::UUID3),
            $this->userApiContext->getUsers()[TestValues::UUID],
            new TaskName(TestValues::TASK_NAME2),
            new \DateTime(TestValues::DATE2)
        );
        $this->tasks[TestValues::UUID3] = $task;

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
            'estimate' => $task->getEstimate()->getValue(),
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
            $this->apiContext->getHeaders(true),
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

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should be able to create a task using existing account
     */
    public function iShouldBeAbleToCreateATaskUsingExistingAccount()
    {
        $payload = [
            'task' => [
                'name' => TestValues::TASK_NAME,
                'date' => TestValues::DATE,
                'description' => TestValues::DESCRIPTION,
                'estimate' => TestValues::ESTIMATE,
                'completed_at' => TestValues::COMPLETED_DATE,
                'time_spent' => TestValues::TIME_SPENT,
                'important' => TestValues::IMPORTANT,
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
            'task.estimate',
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
            $this->apiContext->getHeaders(true),
            []
        );
    }

    /**
     * @Then I should not see a task which doesn't exist
     */
    public function iShouldNotSeeATaskWhichDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(TestValues::UUID);

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should not be able to see a task I don't own
     */
    public function iShouldNotBeAbleToSeeATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(TestValues::UUID2);

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should see details of task I own
     */
    public function iShouldSeeDetailsOfTaskIOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iGetTaskWithId(TestValues::UUID);

        $this->apiContext->iShouldReceiveSuccessResponse();

        $task = $this->getTasks()[TestValues::UUID];
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
            $this->apiContext->getHeaders(true),
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
            $this->getTaskAsArray($this->getTasks()[TestValues::UUID]),
            $this->getTaskAsArray($this->getTasks()[TestValues::UUID3]),
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
            $this->apiContext->getHeaders(true),
            []
        );
    }

    /**
     * @Then I should not be able to delete a task which doesn't exist
     */
    public function iShouldNotBeAbleToDeleteATaskWhichDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(TestValues::UUID);

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should not be able to delete a task I don't own
     */
    public function iShouldNotBeAbleToDeleteATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(TestValues::UUID2);

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should be able to delete a task
     */
    public function iShouldBeAbleToDeleteATask()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iDeleteTaskWithId(TestValues::UUID);

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
            $this->apiContext->getHeaders(true),
            $payload
        );
    }

    /**
     * @Then I should not be able to update a task without an account
     */
    public function iShouldNotBeAbleToUpdateATaskWithoutAnAccount()
    {
        $this->iUpdateTaskWithPayload(TestValues::UUID, '{}');

        $this->apiContext->iShouldReceiveUnauthorizedResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should not be able to update a task if it doesn't exist
     */
    public function iShouldNotBeAbleToUpdateATaskIfItDoesntExist()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(TestValues::UUID, '{}');

        $this->apiContext->iShouldReceiveNotFoundResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should not be able to update a task I don't own
     */
    public function iShouldNotBeAbleToUpdateATaskIDontOwn()
    {
        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(TestValues::UUID2, '{}');

        $this->apiContext->iShouldReceiveForbiddenResponse();

        $this->apiContext->compareResponse([], ['errors']);
    }

    /**
     * @Then I should update a task I own
     */
    public function iShouldUpdateATaskIOwn()
    {
        $payload = [
            'task' => [
                'name' => TestValues::TASK_NAME2,
                'date' => TestValues::DATE2,
                'description' => TestValues::DESCRIPTION,
                'estimate' => TestValues::ESTIMATE,
                'completed_at' => TestValues::COMPLETED_DATE,
                'time_spent' => TestValues::TIME_SPENT,
                'important' => TestValues::IMPORTANT,
            ],
        ];

        $this->userApiContext->iShouldBeAbleToLogInAsExistingUser();

        $this->iUpdateTaskWithPayload(TestValues::UUID, json_encode($payload));

        $this->apiContext->iShouldReceiveSuccessResponse();

        $expected = [
            'task' => [
                'name' => TestValues::TASK_NAME2,
                'date' => TestValues::DATE2,
                'description' => TestValues::DESCRIPTION,
            ],
        ];

        $this->apiContext->compareResponse($expected, [
            'message',
            'task.id',
            'task.estimate',
            'task.completed',
            'task.completed_at',
            'task.time_spent',
            'task.important',
            'task.created_at',
        ]);
    }
}
