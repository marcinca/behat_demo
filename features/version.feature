# features/pages.feature
Feature: pages
  Visit /home and /test urls
  In order to check output is as expected

  Scenario: Version url loads
    Given I am at "http://localhost"
    Then I should see text "This is home page"

  Scenario: Version url loads
    Given I am at "http://localhost/test"
    Then I should see text "This is test page"
