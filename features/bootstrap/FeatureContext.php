<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;
use Behat\Step\Then;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use \Facebook\WebDriver\WebDriverWindow;
use Facebook\WebDriver\WebDriverBy;
use \Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Defines application features from the specific context.
 * 
 */
class FeatureContext implements Context
{
    protected $response;
    protected $data;
    protected $driver;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     *@Given I make a login request with :arg1 and :arg2
     */

     // Makes the POST request with Guzzle.
     // Since I also treated negative requests, I had to ignore Guzzle Exceptions with http_errors => false
    public function iMakeALoginRequestWithAnd($name, $pwd)
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'http://localhost:3001']);
        $this->response = $client->request('POST', '/login', [
            'form_params'=>[
                'username' => $name,
                'password' => $pwd
            ],
            'http_errors' => false,
        ]);
    }

    /**
     * @Then The response should be JSON
     */

    // Checks if the respons is a JSON
    public function theResponseShouldBeJson()
    {
        $this->data = json_decode($this->response->getBody(true));
        if(empty($this->data)){
            throw new Exception("Response was not a JSON");
        }
    }

    /**
    * @Then The response has a :arg1 property
    */
    
    // Checks if a certain property is within the response JSON
    public function theResponseHasAProperty($propertyName)
    {
        if(!empty($this->data)) {
            $userInformationJson = $this->data->user;
            if (!isset($userInformationJson->$propertyName)){
                throw new Exception ("Property " . $propertyName . " is not set!\n");
            }
        }
        else {
                throw new Exception ("Response is not a JSON");
        }
    }

    /** 
    * @Then The :arg1 property equals :arg2
    */

    // Checks if a property has an expected value
    public function thePropertyEquals($propertyName, $propertyValue)
    {
        if(!empty($this->data)) {
            $userInformationJson = $this->data->user;
            if($userInformationJson->$propertyName !== $propertyValue){
                throw new Exception ($userInformationJson->$propertyName . " does not match the expected " . $propertyName . " value of: " . $propertyValue);
            }
        }
        else {
                throw new Exception ("Response is not a JSON");
        }
    }


    /**
     * @Then The response status code should be :arg1
     */

     // Checks the response status code
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        $responseCode = $this->response->getStatusCode();

        if ($responseCode == $statusCode ){
            return true;
        }
        else{
              throw new Exception("Expected status code " . $statusCode . " but received status code " . $responseCode);
        }
    }

    /**
    * @Then The response phrase should be :arg1
    */

    // Checks the phase of the response
    public function theResponsePhraseShouldBe($phase)
    {
        $responsePhrase = $this->response->getbody();

        if ($responsePhrase == $phase ){
            return true;
        }
        else{
              throw new Exception("Expected response phrase " . $phase . " but received " . $responsePhrase);
        }    
    }


    /**
    * @Given I am on the login page
    */

    // Creates the browser session
    // Opens a browser
    public function iAmOnTheLoginPage()
    {
        // This is where Selenium and Chromedriver listens by default.
        $serverUrl = 'http://localhost:4444/wd/hub/';

        // Starts the browser and initiates the session
        $this->driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

        // Navigates to http://localhost:3000/signin
        $this->driver->get('http://localhost:3000/signin');

        // Maximizes the browser's window
        $this->driver->manage()->window()->maximize();
    }

    /**
    * @When I input the username :arg1
    */
    
    // Inputs the username data into the username field
    public function iInputTheUsername($username)
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#username'))->sendKeys($username);
    }

    /**
    * @When I input the password :arg1
    */

    // Inputs the password data into the password field
    public function iInputThePassword($password)
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#password'))->sendKeys($password);
    }

    /**
    * @When I press the sign in
    */

    // Clicks the Sign in button
    public function iPressTheSignIn()
    {
        $this->driver->findElement(WebDriverBy::cssSelector('form >button'))->click();
    }

    /**
    * @Then I should see the homepage logo
    */

    // Checks for the Everyone tab on the Homepage
    public function iShouldSeeTheHomepageLogo()
    {
        // waits until the homepage loads after login
        $this->driver->wait()->until(
            WebDriverExpectedCondition::refreshed(
                WebDriverExpectedCondition::presenceOfElementLocated(
                    WebDriverBy::cssSelector('g > path:nth-child(1)')
                )
            )
        );

       if ($this->driver->findElement(WebDriverBy::cssSelector('div > div > a:nth-child(1)'))->getText() !== "EVERYONE"){
            throw new Exception ("Not redirected to the homepage");
       }
    }

    /**
    * @Then :arg1 should be displayed on the top left corner
    */

    // Checks that the username is displayed on the top-left side of the page 
    public function shouldBeDisplayedOnTheTopLeftCorner($name)
    {
        if ($this->driver->findElement(WebDriverBy::cssSelector('div:nth-child(2) > h6:nth-child(2)'))->getText() !== $name){
            throw new Exception ("Not redirected to the homepage");
        }

        // terminates the session and closes the browser
        $this->driver->quit();
    }

    /**
    * @Then The :arg1 message appears
    */

    // Checks that an error message is displayed if attempting to login without a username
    public function theMessageAppears($msg)
    {
        if ($this->driver->findElement(WebDriverBy::cssSelector('#username-helper-text'))->getText() !== $msg){
            throw new Exception ("Sign in without a username!");
       }

       // terminates the session and closes the browser
       $this->driver->quit();
    }

    /**
    * @When I click away
    */

    // Clicks on an element on the page
    public function iClickAway()
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#username'))->click();
    }

    /**
    * @Then A :arg1 meesage is displayed
    */

    // Checks that the correct error message is displayed if attempting to login with a password shorter than 4 characters
    public function aMeesageIsDisplayed($msg)
    {
        if ($this->driver->findElement(WebDriverBy::cssSelector('#password-helper-text'))->getText() !== $msg){
            throw new Exception ("Sign in with a password that is less than 4 characters!");
       }
    }

    /**
    * @Then The Sign In button is disabled
    */

    // Check that the Sign in button is disabled
    public function theSignInButtonIsDisabled()
    {
        if ($this->driver->findElement(WebDriverBy::cssSelector('form > button'))->isEnabled()){
            throw new Exception ("Sign in button is enabled even if the password has less than 4 characters!");
       }

       // terminates the session and closes the browser
       $this->driver->quit();
    }

    /**
    * @Then A :arg1 message is shown
    */

    // Checks the error message for attempting to login with invalid credentials
    public function aMessageIsShown($msg)
    {

        $this->driver->manage()->timeouts()->implicitlyWait(2);

        if ($this->driver->findElement(WebDriverBy::cssSelector('div.MuiAlert-message.css-1pxa9xg-MuiAlert-message'))->getText() !== $msg){
            throw new Exception ("No invalid credential message!");
       }
       //close session
       $this->driver->quit();
    }
}
