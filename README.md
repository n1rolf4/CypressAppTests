# 1. General Description

The project tests the login functionality of the Cypress.io website.
As the OOP language PHP was used, the automation framework was Selenium and for the test framework Behat was used.

2 types of tests were implemented:
- api tests (POST requests to the backend login api http://localhost:3001)
- functional tests (tested the login page http://localhost:3000/signin)
Both suites of test include positive and negative scenarios.The scenarios cover the following:

## API:
- A valid login request with correct username and password
- Login request without a username
- Login request without a password (an additional scenario was created to test if the password is case-sensitive)
- Login request with invalid username
- Login request with invalid password
- Separate login requests with user's email, First_Name, Last_Name and user_Id instead of username

## Front-End:
- A valid login request with correct username and password
- A login without a username and password
- A login with a password under 4 characters
- A login with invalid username
- A login with invalid password
- A login with user's email, First_Name, Last_Name and instead of username


The scenarios are written in Gherkin format and are grouped in 2 files (api_login.feature for the API tests and UI_login.feature for the Front-End tests), while the methods behind the steps were implemented in FeatureContext.php.


# 2. Install and setup steps

## 2.1. Prerequisites
- download the test website locally from https://github.com/cypress-io/cypress-realworld-app
- install Java from https://www.java.com/en/download/manual.jsp
- install Java SDK from https://www.oracle.com/ca-en/java/technologies/downloads/#jdk24-windows (I ran the application on Windows, so I downloaded the Windows version)
- make sure to have the JAVA and JAVA JRE folders saved in the System environment variables - Environment Variables - System variables Path
`C:\Program Files\Java\jdk-24\bin`
`C:\Program Files (x86)\Java\latest\jre-1.8\bin`
- clone my git repository from `git@github.com:n1rolf4/CypressAppTests.git`
- install PHP from https://www.php.net/downloads.php then add the unarchived folder to the system environment variable PATH
- install composer from https://getcomposer.org/download/ (when installing composer and asking you to choose the command-line PHP you want to use, make sure to use the above downloaded PHP path during the composer installation)
- go to the root folder that was downloaded from my git repository and run `composer update`

# 3. How to run the automated tests:

### a. Wake up the Cypress local environment
Go to the local test website folder (the cypress realworld app folder) and run yarn dev. Since the project includes API tests, wait for the backend (http://localhost:3001) to start.

### b. Start the Selenium server
The Selenium standalone server file has been included in the project so you don't need to download again.
Within the terminal, go to the root folder that was downloaded from my git repository and find the selenium .jar file within the Selenium_server folder.
```
cd Selenium_server
java -jar selenium-server-standalone-3.5.0.jar
```


### c. Run the test with Behat
Within the terminal, go to the root folder that was downloaded from my git repository (vendor folder should be visible after running composer update), and run the following command:
 
`.\vendor\bin\behat` it should run the entire suite of tests (api + functional).

there are several other options for running the tests:
For example if you want to run only the API tests the following command should be run:
`.\vendor\bin\behat .\features\api_login.feature`

similarly for the functional tests:
`.\vendor\bin\behat .\features\UI_login.feature`

After finishing, more information about the tests will be displayed:
- number of tests ran (how many have passed, failed or skipped if it is the case)
- number of steps ran
- the time of the run and how much memory has been used

A video demo is included into the project (check the DEMO folder) to demonstrate the full process of running the tests.


# 4. FAQ

1. If the functional tests fail, then restart the selenium server.