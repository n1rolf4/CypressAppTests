Feature: Login from the UI

Scenario: I can login form the interface using correct credentials
Given I am on the login page
When I input the username "Dina20"
And I input the password "s3cret"
And I press the sign in
Then I should see the homepage logo
And "@Dina20" should be displayed on the top left corner

Scenario: I can't login from the interface if I don't input any credentials
Given I am on the login page
When I press the sign in
Then The "Username is required" message appears

Scenario: I can't login with a password under 4 characters long
Given I am on the login page
When I input the username "Heath93"
And I input the password "s3c"
And I click away
Then A "Password must contain at least 4 characters" meesage is displayed
And The Sign In button is disabled


Scenario: I can't login with invalid credentials
Given I am on the login page
When I input the username <username>
And I input the password <password>
And I press the sign in
Then A "Username or password is invalid" message is shown

Examples:

|username                   |password        |
|"Arvilla_Hegmann"          |"wrong_password"|
|"Wrong_username"           |"s3cret"        |
|"Skyla.Stamm@yahoo.com"    |"s3cret"        |
|"Kristian"                 |"s3cret"        |
|"Bradtke"                  |"s3cret"        |
