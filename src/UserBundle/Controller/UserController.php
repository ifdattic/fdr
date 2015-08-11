<?php

namespace UserBundle\Controller;

use AppBundle\Controller\ApiController;
use Domain\User\Command\GetUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Form\Type\SignUpCommandType;

class UserController extends ApiController
{
    public function getTokenAction()
    {
        return new Response('', 401);
    }

    public function getLoggedInUserDataAction()
    {
        $userProvider = $this->get('user_provider');
        $userId = $userProvider->getUser()->getId();

        $command = new GetUser($userId);

        $this->getCommandBus()->handle($command);

        $user = $command->getUser();

        return $this
            ->setStatusCode(Response::HTTP_OK)
            ->setData(['user' => $user])
            ->respond()
        ;
    }

    public function signUpAction(Request $request)
    {
        $form = $this->createForm(new SignUpCommandType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();

            $this->getCommandBus()->handle($command);

            if ($command->hasErrors()) {
                return $this->respondWithErrors($command->getErrors());
            }

            return $this
                ->setData(['message' => 'Sign up successful.'])
                ->setStatusCode(Response::HTTP_CREATED)
                ->respond()
            ;
        }

        return $this->respondWithForm($form);
    }
}
