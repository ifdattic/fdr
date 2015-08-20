<?php

namespace AppBundle\Controller;

use AppBundle\Exception\ExceptionClassMap;
use Domain\Core\Exception\DomainException;
use Domain\Core\Validation\Error;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /** @var array */
    protected $data = [];

    /** @var int */
    protected $statusCode = Response::HTTP_OK;

    /** @var array */
    private static $contentTypes = [
        'json' => 'application/json',
    ];

    /** @var string */
    private $format = 'json';

    /**
     * @param int $statusCode
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;

        return $this;
    }

    /**
     * Set the data to respond with.
     *
     * @param array $data
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Respond with set data.
     *
     * @return Response
     */
    protected function respond()
    {
        $data = $this->getSerializer()->serialize($this->data, $this->format, $this->getSerializationContext());

        $response = new Response($data, $this->statusCode);

        if (array_key_exists($this->format, self::$contentTypes)) {
            $response->headers->set('Content-Type', self::$contentTypes[$this->format]);
        }

        return $response;
    }

    /**
     * @param FormInterface $form
     * @return Response
     */
    protected function respondWithForm(FormInterface $form)
    {
        $errors = $this->getFormErrorExtractor()->extract($form);

        return $this->respondWithErrors($errors ?: ['Invalid request']);
    }

    /**
     * @param  array  $errorMessages
     * @return Response
     */
    protected function respondWithErrors(array $errorMessages)
    {
        $statusCode = Response::HTTP_BAD_REQUEST;
        $errors = [];

        foreach ($errorMessages as $error) {
            $errors[] = $this->formatError($error, $statusCode);
        }

        return $this->sendErrors($errors, $statusCode);
    }

    /**
     * @param  string|Error $error
     * @param  int $code
     * @return array
     */
    private function formatError($error, $code = Response::HTTP_BAD_REQUEST)
    {
        $field = $error instanceof Error ? $error->getField() : null;

        $statusTexts = Response::$statusTexts;

        return [
            'status_code' => $this->isValidStatusCode($code) ? $code : Response::HTTP_BAD_REQUEST,
            'status_text' => $this->isValidStatusCode($code) ? $statusTexts[$code] : $statusTexts[Response::HTTP_BAD_REQUEST],
            'message' => (string) $error,
            'field' => $field,
        ];
    }

    /**
     * @param  FlattenException $exception
     * @return Response
     */
    public function showExceptionAction(FlattenException $exception)
    {
        $message = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        $class = $exception->getClass();
        $exceptionMap = new ExceptionClassMap();
        $statusCode = $exceptionMap->getStatusCode($class);

        if ($exceptionMap->canGetMessage($class) || !$this->isProduction()) {
            $message = $exception->getMessage();
        }

        $errors = [
            $this->formatError($message, $statusCode),
        ];

        return $this->sendErrors($errors, $statusCode);
    }

    /**
     * @param  array  $errors
     * @param  int $statusCode
     * @return Response
     */
    private function sendErrors(array $errors, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        if (!$this->isValidStatusCode($statusCode)) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return $this
            ->setStatusCode($statusCode)
            ->setData(['errors' => $errors])
            ->respond()
        ;
    }

    /**
     * @param  int  $statusCode
     * @return boolean
     */
    private function isValidStatusCode($statusCode)
    {
        return array_key_exists($statusCode, Response::$statusTexts);
    }

    /** @return SimpleBus\Message\Bus\MessageBus */
    protected function getCommandBus()
    {
        return $this->get('command_bus');
    }

    /** @return JMS\Serializer\Serializer */
    protected function getSerializer()
    {
        return $this->get('jms_serializer');
    }

    /** @return JMS\Serializer\SerializationContext */
    protected function getSerializationContext()
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $context;
    }

    /** @return AppBundle\Form\ErrorExtractor */
    protected function getFormErrorExtractor()
    {
        return $this->get('form.error_extractor');
    }
}
