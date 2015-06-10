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
}
