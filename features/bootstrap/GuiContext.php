<?php
/**
 * @url //michaelheap.com/behat-selenium2-webdriver/
 */

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Driver\GoutteDriver;
use Goutte\Client as GoutteClient;

class GuiContext extends MinkContext implements Context
{
    /**
     * @var Session
     */
    protected $mink;
    protected $browser;
    protected $url;

    /**
     * GuiContext constructor.
     */
    public function __construct()
    {
        $this->browser = 'firefox';
        $this->url = 'http://localhost/version1';

        $this->mink = new Mink([
            'goutte1' => new Session(new GoutteDriver(new GoutteClient())),
            //'selenium2' => new Session(new Selenium2Driver($this->browser, null,  $this->url)),
        ]);

        // set the default session name
        $this->mink->setDefaultSessionName('goutte1');
    }

    /**
     * Before every scenario log in to HTTP basic auth.
     *
     * @BeforeScenario
     */
    public function beforeScenario(BeforeScenarioScope $scope) {
        $username = 'user';
        getenv("USER_PASSWORD", 'password');
        $this->mink->getSession()->setBasicAuth($username, getenv("USER_PASSWORD"));
    }

    /**
     * @Given /^I am at "([^"]*)"$/
     */
    public function iAmAt($url)
    {
        $this->mink->getSession('goutte1')->visit($url);
        $content = $this->mink->getSession('goutte1')->getPage()->getContent();
        if (!$content) {
            throw new Exception(
                "The url is:\n" . $url . ""
            );
        }
    }

    /**
     * @Then /^I fill "([^"]*)" into ([^"]*)$/
     */
    public function iFillInto($value, $xpath)
    {
        $session = $this->mink->getSession('goutte1');
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        );

        if (!$element) {
            throw new Exception(
                "unable to fill in the field\n" . $xpath
            );
        }
        $element->setValue($value);
    }

    /**
     * @Then I should see text :arg1
     */
    public function iShouldSeeText($arg1)
    {
        $check = $this->mink->getSession('goutte1')->getPage()->hasContent($arg1);
        if (!$check) {
            throw new Exception(
                "String not found:\n" . $arg1 . ""
            );
        }
    }

    /**
     * @Then /^I should see "([^"]*)" element$/
     */
    public function iShouldSeeElement($arg1)
    {
        $found = $this->mink->getSession('goutte1')->getPage()->hasField($arg1);
        if (!$found) {
            throw new Exception(
                "Element not found:\n" . $arg1
            );
        }
    }

    /**
     * @Then /^I should see "([^"]*)" button$/
     */
    public function iShouldSeeButton($arg1)
    {
        $found = $this->mink->getSession('goutte1')->getPage()->hasButton($arg1);
        if (!$found) {
            throw new Exception(
                "Button not found:\n" . $arg1
            );
        }
    }

    /**
     * @When /^I click on the element with xpath ([^"]*)$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->mink->getSession('goutte1'); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        );

        if (is_null($element)) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        // ok, let's click on it
        $element->click();
    }

    /**
     * @Then I am redirected :arg1
     */
    public function iAmRedirected($page = null)
    {
        $headers = $this->mink->getSession('goutte1')->getResponseHeaders();
        if (empty($headers['Location']) && empty($headers['location'])) {
            throw new \RuntimeException('The response should contain a "Location" header');
        }
        if (null !== $page) {
            $header = empty($headers['Location']) ? $headers['location'] : $headers['Location'];
            if (is_array($header)) {
                $header = current($header);
            }
        }
        if ($header != $this->locatePath($page)) {
            throw new \RuntimeException('The "Location" header points to the correct URI');
        }
    }

    /**
     * Then /^the response should contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function theResponseShouldContain($text)
    {
        $this->assertPageContainsText($text);
    }
}
