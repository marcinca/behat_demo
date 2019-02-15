# features/zauth.feature
Feature: zauth
  Check form fields, fill in incorrect login details and login to a website, you should see error message

  Scenario: Logon page loads
    Given I am at "http://localhost/login"
    Then I should see "email" element
    And I should see "password" element
    And I should see "login" button

  Scenario: Login with incorrect username password
    Given I am at "http://localhost/login"
    When I fill "test@test" into //input[@name='email']
    When I click on the element with xpath //input[@name='login']
    Then I should see text 'Invalid login'
