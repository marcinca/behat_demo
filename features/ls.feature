# features/ls.feature
Feature: ls
  In order to see the directory structure
  As a UNIX user
  I need to be able to list the current directory's contents

  Scenario: List 2 files in a directory
    Given I am in a directory "behatapp"
    And I have a file named "composer.json"
    And I have a file named "composer.lock"
    When I run "ls"
    Then I should get:
      """
      composer.json
      composer.lock
      """
