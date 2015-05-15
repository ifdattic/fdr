<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\SignUpCommandType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    /**
     * @Rest\View
     */
    public function allAction()
    {
        $users = $this->get('user_repository')->findAll();

        return ['users' => $users];
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
