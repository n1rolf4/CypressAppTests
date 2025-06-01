Feature: Login on the api

Scenario: I can login with correct credentials
Given I make a login request with "Dina20" and "s3cret"
Then The response should be JSON
And The response status code should be 200
And The response has a "id" property
And The "id" property equals "_XblMqbuoP"


Scenario: I can't login with invalid credentials
Given I make a login request with <username> and <password>
Then The response status code should be <response>
And The response phrase should be <phrase>

Examples:

| username                       | password   | response | phrase         |
| "Heath93"                      | "s2cret"   | 401      | "Unauthorized" |
| "Heath93"                      | "S3CRET"   | 401      | "Unauthorized" |
| "Santos.Runte65@gmail.com"     | "s3cret"   | 401      | "Unauthorized" |
| "Kristian"                     | "s3cret"   | 401      | "Unauthorized" |
| "Bradtke"                      | "s3cret"   | 401      | "Unauthorized" |
| "GjWovtg2hr"                   | "s3cret"   | 401      | "Unauthorized" |
| ""                             | "s3cret"   | 400      | "Bad Request"  |
| "Heath93"                      | ""         | 400      | "Bad Request"  |