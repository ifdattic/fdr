<?php

namespace TaskBundle\Controller;

use AppBundle\Controller\ApiController;
use Domain\Task\Command\DeleteTask;
use Domain\Task\Command\GetTask;
use Domain\Task\Command\GetTasksByUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Form\Type\CreateTaskCommandType;
use TaskBundle\Form\Type\UpdateTaskCommandType;

class TaskController extends ApiController
{
    public function createAction(Request $request)
    {
        $user = $this->get('user_provider')->getUser();
        $form = $this->createForm(new CreateTaskCommandType($user));

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->respondWithForm($form);
        }

        $command = $form->getData();
        $this->getCommandBus()->handle($command);

        if ($command->hasErrors()) {
            return $this->respondWithErrors($command->getErrors());
        }

        $message = 'Task created.';

        return $this
            ->setStatusCode(Response::HTTP_CREATED)
            ->setData([
                'message' => $message,
                'task' => $command->getTask(),
            ])
            ->respond()
        ;
    }

    public function getAction($id)
    {
        $command = new GetTask($id);

        $this->getCommandBus()->handle($command);

        $task = $command->getTask();

        return $this
            ->setData(['task' => $task])
            ->respond()
        ;
    }

    public function getAllAction()
    {
        $user = $this->get('user_provider')->getUser();
        $command = new GetTasksByUser($user);

        $this->getCommandBus()->handle($command);

        $tasks = $command->getTasks();

        return $this
            ->setData(['tasks' => $tasks])
            ->respond()
        ;
    }

    public function deleteAction($id)
    {
        $command = new DeleteTask($id);

        $this->getCommandBus()->handle($command);

        return $this
            ->setData([])
            ->respond()
        ;
    }

    public function updateAction(Request $request, $id)
    {
        $command = new GetTask($id);

        $this->getCommandBus()->handle($command);

        $task = $command->getTask();

        $form = $this->createForm(new UpdateTaskCommandType($task), null, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->respondWithForm($form);
        }

        $command = $form->getData();

        $this->getCommandBus()->handle($command);

        if ($command->hasErrors()) {
            return $this->respondWithErrors($command->getErrors());
        }

        $message = 'Task updated.';

        return $this
            ->setData([
                'message' => $message,
                'task' => $command->getTask(),
            ])
            ->respond()
        ;
    }
}
