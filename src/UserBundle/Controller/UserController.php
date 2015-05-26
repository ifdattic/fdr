<?php

namespace UserBundle\Controller;

use AppBundle\Controller\ApiController;
use Domain\User\Command\GetUser;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Form\Type\SignUpCommandType;

class UserController extends ApiController
{
    /**
     * Get authentication token.
     *
     * #### Example of invalid response
     *
     * ```
     * {
     *   "code": 401,
     *   "message": "Bad credentials"
     * }
     *
     * ```
     *
     * #### Example of successful response
     *
     * ```
     * {
     *   "token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9.eyJleHAiOjE0NDA0MTMzOTEsInVzZXJuYW1lIjoidmlyZ2lsQG11bmRlbGwuY29tIiwiaWF0IjoiMTQzMjYzNzM5MSJ9.FlmdaElgoaXZS-udPi5SN6P6R7ftHX58UibxXdEI8Qyq86l_AirbSUrMy3PEKAdQH7tn11PohQLdJ0ktswhR5GLRo3xJgljyGVjRk3IcMT4NQ8nRecjlDHUUWVQ-Mc4wB3Mkca4-cx--57c_XwZuwprl_PyKS8OvULludIyo1gFIzCIPS1zj_auTTArnQBhUZH33QxtpsMBpnHL97HJKAZgyITfT8g97QrPbIgiTw9SZRwe4F5jBeh5E1_f8VxMGCJ7NifmcrqhjXHW4SPJa_8Mvhxec89j2VnWi3gVlu6lfTfmf8a3RMHIppuQ3EpJtzzu8F8PulILhUmsygBkFh1BkaTrxGvJRuvIR_niBf1RVdB1E8W3kV4JUzmp86tdC0HesB_MCTgymmNO3oXq9mIeo4zJ65CWiDnsbNbohJ-qWpGSbGGMky3L2bDrm1TomAr4wf75FTn09vw3fJWuUI0_uOXoFUdcEMOaCwEI_otdt1ryeblQgtTclmcDN7-k8E7sN2y9YOxcKbdTHVvwWT5mzi_0pKSKholZXE6R1J7YYDFAsA6cn80DQ4nMLCqqNzm5DENnjWddOOuKV0h_SG25A4b1xBOVYXk2-6g-2csq45SIO1wQauU4Bz6kvj4GKNgdV7DGkstJeSkrExPyGt79GMIO684xwPwmL6frihBQ"
     * }
     * ```
     *
     * @ApiDoc(
     *     parameters={
     *         {"name"="email", "dataType"="string", "required"=true, "description"="Email to authenticate with"},
     *         {"name"="password", "dataType"="string", "required"=true}
     *     },
     *     statusCodes={
     *         200="Returned when successful",
     *         401="Returned when authentication fails"
     *     },
     *     tags={"info"="#0F6AB4"}
     * )
     */
    public function getTokenAction()
    {
        return new Response('', 401);
    }

    /**
     * Get data of currently logged in user.
     *
     * #### Example of invalid response
     *
     * ```
     * {
     *   "code": 401,
     *   "message": "Invalid credentials"
     * }
     * ```
     *
     * #### Example of successful response
     *
     * ```
     * {
     *   "user": {
     *     "id": "5399dbab-ccd0-493c-be1a-67300de1671f",
     *     "email": "virgil@mundell.com",
     *     "full_name": "Virgil Mundell"
     *   }
     * }
     * ```
     *
     * @ApiDoc(
     *     resource=true,
     *     authentication=true,
     *     statusCodes={
     *         200="Returned when successful",
     *         401="Returned when authentication fails"
     *     },
     *     tags={"info"="#0F6AB4"}
     * )
     */
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

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $users = $this->get('user_repository')->findAll();

        return ['users' => $users];
    }

    /**
     * Sign up for an account.
     *
     * **After successful response the application should make a call for authentication.**
     *
     * #### Example of successful response
     *
     * ```
     * {
     *   "message": "Sign up successful."
     * }
     * ```
     *
     * #### Example of invalid form response
     *
     * ```
     * {
     *   "code": 400,
     *   "message": "Bad Request"
     * }
     * ```
     *
     * #### Example of failed validation response
     *
     * ```
     * {
     *   "errors": [
     *     {
     *       "message": "The \"v\" is not a valid email",
     *       "field": "email",
     *       "code": 1
     *     },
     *     {
     *       "message": "The full name is required",
     *       "field": "full_name"
     *     },
     *     {
     *       "message": "Password must be at least 8 characters",
     *       "field": "password",
     *       "code": 1
     *     }
     *   ]
     * }
     * ```
     *
     * #### Example of existing account response
     *
     * ```
     * {
     *   "errors": [
     *     {
     *       "message": "User with this email already exists",
     *       "field": "email"
     *     }
     *   ]
     * }
     * ```
     *
     * @ApiDoc(
     *     input="UserBundle\Form\Type\SignUpCommandType",
     *     output="Domain\User\Entity\User",
     *     statusCodes={
     *         201="Returned when successful",
     *         400={
     *             "Returned when request is invalid",
     *             "Returned when validation fails",
     *             "Returned when account exists"
     *         }
     *     },
     *     tags={"info"="#0F6AB4"}
     * )
     */
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
