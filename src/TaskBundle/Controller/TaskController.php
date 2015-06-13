<?php

namespace TaskBundle\Controller;

use AppBundle\Controller\ApiController;
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
     *     "important": true
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
}
