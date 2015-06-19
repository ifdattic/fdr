<?php

namespace AppBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;

class ApiContext implements Context
{
    /** @var Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /** @var Behat\Mink\Session */
    private $session;

    /**
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');

        $this->session = $this->minkContext->getSession();
    }

    /** @return Behat\Mink\Session */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Locates path from a relative one.
     *
     * @param  string $path
     * @return string
     */
    public function locatePath($path)
    {
        return $this->minkContext->locatePath($path);
    }

    /**
     * @Then I should receive success response
     */
    public function iShouldReceiveSuccessResponse()
    {
        Assert::assertSame(200, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive created response
     */
    public function iShouldReceiveCreatedResponse()
    {
        Assert::assertSame(201, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive bad request response
     */
    public function iShouldReceiveBadRequestResponse()
    {
        Assert::assertSame(400, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive unauthorized response
     */
    public function iShouldReceiveUnauthorizedResponse()
    {
        Assert::assertSame(401, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive forbidden response
     */
    public function iShouldReceiveForbiddenResponse()
    {
        Assert::assertSame(403, $this->session->getStatusCode());
    }

    /**
     * @Then I should receive not found response
     */
    public function iShouldReceiveNotFoundResponse()
    {
        Assert::assertSame(404, $this->session->getStatusCode());
    }

    /**
     * Get the content of a response
     *
     * @return string
     */
    public function getResponseContent()
    {
        return $this->session->getPage()->getContent();
    }

    /**
     * @When I get response content
     */
    public function iGetResponseContent()
    {
        echo $this->getResponseContent();
    }

    /**
     * Compare the response.
     *
     * @param  array  $expected
     * @param  array  $containsKeys keys response should have, use when
     * comparison against value is not needed. Separate levels using a dot (.)
     * @throws \PHPUnit_Framework_ExpectationFailedException if response is different
     */
    public function compareResponse(array $expected, array $containsKeys = [])
    {
        $response = json_decode($this->getResponseContent(), true);

        foreach ($containsKeys as $key) {
            $this->responseHasKey($response, $key);
        }

        Assert::assertSame($expected, $response);
    }

    /**
     * Check if response has a key.
     *
     * @param  array &$response
     * @param  string $key
     * @throws \PHPUnit_Framework_ExpectationFailedException if response doesn't have a key
     */
    private function responseHasKey(&$response, $key)
    {
        $position = strpos($key, '.');

        if (false !== $position) {
            $parentKey = substr($key, 0, $position);
            $nextKey = substr($key, $position + 1);

            $this->responseHasKey($response[$parentKey], $nextKey);
        } else {
            Assert::assertArrayHasKey($key, $response, 'Response is missing required key');

            unset($response[$key]);
        }
    }
}
