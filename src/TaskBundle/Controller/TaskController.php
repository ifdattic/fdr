<?php

namespace TaskBundle\Controller;

use AppBundle\Controller\ApiController;
use Domain\Task\Command\GetTask;
use Domain\Task\Command\GetTasksByUser;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Form\Type\CreateTaskCommandType;

class TaskController extends ApiController
{
    /**
     * Create a new task.
     *
     * If task is **not completed it has no `completed_at`** in the response!
     *
     * #### Example of successful response
     *
     * ```
     * {
     *   "message": "Task created.",
     *   "task": {
     *     "id": "b4b60f6f-9454-4e03-b9fe-80066e9ac441",
     *     "name": "Task name",
     *     "date": "2015-06-28T00:00:00+0000",
     *     "description": "This is task description",
     *     "estimated": 3,
     *     "completed": true,
     *     "completed_at": "2015-05-05T05:05:05+0000",
     *     "time_spent": 23,
     *     "important": true,
     *     "created_at": "2015-04-14T06:12:29+0000"
     *   }
     * }
     * ```
     *
     * #### Example of failed validation response
     *
     * ```
     * {
     *   "errors": [
     *     {
     *       "message": "Task name is required",
     *       "field": "name"
     *     },
     *     {
     *       "message": "Date is required",
     *       "field": "date"
     *     }
     *   ]
     * }
     * ```
     *
     * @ApiDoc(
     *     resource=true,
     *     authentication=true,
     *     input="TaskBundle\Form\Type\CreateTaskCommandType",
     *     output="Domain\Task\Entity\Task",
     *     statusCodes={
     *         201="Returned when successful",
     *         400={
     *             "Returned when request is invalid",
     *             "Returned when validation fails"
     *         }
     *     }
     * )
     */
    public function createAction(Request $request)
    {
        $user = $this->get('user_provider')->getUser();
        $form = $this->createForm(new CreateTaskCommandType($user));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();

            $this->getCommandBus()->handle($command);

            if ($command->hasErrors()) {
                return $this->respondWithErrors($command->getErrors());
            }

            return $this
                ->setData([
                    'message' => 'Task created.',
                    'task' => $command->getTask(),
                ])
                ->setStatusCode(Response::HTTP_CREATED)
                ->respond()
            ;
        }

        return $this->respondWithForm($form);
    }

    /**
     * Get data of a task.
     *
     * ### Example of successful response
     *
     * ```
     * {
     *   "task": {
     *     "id": "5399dbab-ccd0-493c-be1a-67300de1671f",
     *     "name": "Task Name",
     *     "date": "2015-04-15",
     *     "description": "This is the description.",
     *     "estimated": 3,
     *     "completed": true,
     *     "completed_at": "2015-04-15T13:14:15+0000",
     *     "time_spent": 23,
     *     "important": true,
     *     "created_at": "2015-06-18T07:13:26+0000"
     *   }
     * }
     * ```
     *
     * ### Example of response when not an owner of a task
     *
     * ```
     * {
     *   "code": 403,
     *   "message": "Access Denied",
     *   "errors": null
     * }
     * ```
     *
     * ### Example when task is not found response
     *
     * ```
     * {
     *   "code": 404,
     *   "message": "Task not found",
     *   "errors": null
     * }
     * ```
     *
     * @ApiDoc(
     *     resource=true,
     *     authentication=true,
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when not an owner of a resource",
     *         404="Returned when resource not found"
     *     }
     * )
     */
    public function getAction($id)
    {
        $command = new GetTask($id);

        $this->getCommandBus()->handle($command);

        $task = $command->getTask();

        return $this
            ->setStatusCode(Response::HTTP_OK)
            ->setData(['task' => $task])
            ->respond()
        ;
    }

    /**
     * Get all user tasks.
     *
     * ### Example of response when user has tasks
     *
     * ```
     * {
     *   "tasks": [
     *     {
     *       "id": "5399dbab-ccd0-493c-be1a-67300de1671f",
     *       "name": "Task Name",
     *       "date": "2015-04-15",
     *       "description": "This is the description.",
     *       "estimated": 3,
     *       "completed": true,
     *       "completed_at": "2015-04-15T13:14:15+0000",
     *       "time_spent": 23,
     *       "important": true,
     *       "created_at": "2015-06-20T07:21:54+0000"
     *     },
     *     {
     *       "id": "df603d36-1203-4bc5-9cd8-99c775ac272a",
     *       "name": "Task Name Alternative",
     *       "date": "2014-06-05",
     *       "description": null,
     *       "estimated": 1,
     *       "completed": false,
     *       "completed_at": null,
     *       "time_spent": 0,
     *       "important": true,
     *       "created_at": "2015-06-20T07:21:54+0000"
     *     }
     *   ]
     * }
     * ```
     *
     * ### Example of response when user has no tasks
     *
     * ```
     * {
     *   "tasks": []
     * }
     * ```
     *
     * @ApiDoc(
     *     resource=true,
     *     authentication=true,
     *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
     */
    public function getAllAction()
    {
        $user = $this->get('user_provider')->getUser();
        $command = new GetTasksByUser($user);

        $this->getCommandBus()->handle($command);

        $tasks = $command->getTasks();

        return $this
            ->setStatusCode(Response::HTTP_OK)
            ->setData(['tasks' => $tasks])
            ->respond()
        ;
    }
}
