<?php
/**
 * @url //michaelheap.com/behat-selenium2-webdriver/
 */

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Behat\Context\Context;
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
     * @Given /^I am at "([^"]*)"$/
     */
    public function iAmAt($url)
    {
        $this->mink->getSession()->visit($url);
        $content = $this->mink->getSession()->getPage()->getContent();
        if (!$content) {
            throw new Exception(
                "The url is:\n" . $url . ""
            );
        }
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
     * Then /^the response should contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function theResponseShouldContain($text)
    {
        $this->assertPageContainsText($text);
    }
}
