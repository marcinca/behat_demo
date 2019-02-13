# features/version.feature
Feature: version
  In order to see an api version number

  Scenario: Version url loads
    Given I am at "http://localhost/version"
    Then I should see text 'v1.00'
