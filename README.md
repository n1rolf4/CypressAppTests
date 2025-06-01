1. General Description

The project tests the login functionality of the Cypress.io website.
As the OOP language PHP was used, the automation framework was Selenium and for the test framework Behat was used.

2 types of tests were implemented:
	- api tests (POST requests to the backend login api http://localhost:3001)
	- functional tests (tested the login page http://localhost:3000/signin)
Both suites of test include positive and negative scenarios.The scenarios cover the following:

API:
- A valid login request with correct username and password
- Login request without a username
- Login request without a password (an additional scenario was created to test if the password is case-sensitive)
- Login request with invalid username
- Login request with invalid password
- Separate login requests with user's email, First_Name, Last_Name and user_Id instead of username

Front-End:
- A valid login request with correct username and password
- A login without a username and password
- A login with a password under 4 characters
- A login with invalid username
- A login with invalid password
- A login with user's email, First_Name, Last_Name and instead of username


The scenarios are written in Gherkin format and are grouped in 2 files (api_login.feature for the API tests and UI_login.feature for the Front-End tests), while the methods behind the steps were implemented in FeatureContext.php.


2. Install and setup steps

2.1. Prerequisites

3. How to run the automated tests:

a. Wake up the Cypress local environment
Go to the folder where Cypress.io is set up and run yarn dev. Since the project includes API tests, wait for the backend(http://localhost:3001) to be up too.

b. Start the Selenium server
The Selenium standalone server file has been included in the project so it doesn't need to be downloaded agian.
Within a terminal go to the current project (Cypress.io) and find the selenium .jar file within folder (Selenium_server). From the context of the selenium_server folder run java -jar selenium-server-standalone-3.5.0.jar

c. Run the test with Behat
Within a terminal go to the main project folder (vendor folder should be visible), an run the following command:
.\vendor\bin\behat that should run the entire suite of tests (api + functional).

there are several other options that you can run the tests:
For example if you want to run only the API tests the following command should be run:
.\vendor\bin\behat .\features\api_login.feature

similar for the functional tests:
.\vendor\bin\behat .\features\UI_login.feature

After finishing, more information about the run will be displayed:
- number of tests ran (how many have passed, failed or skipped if it is the case)
- number of steps ran
- the time of the run and how much memory has been used

A video demo is included into the project (check the DEMO folder) to demonstrate the full process of running the tests.

