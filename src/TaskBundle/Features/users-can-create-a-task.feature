Feature: A user can create a task
    In order to plan my week
    As a user
    I need to create a task

    Scenario: Task can not be created without an account
        Then I should not be able to create a task without an account

    Scenario: Task can be created
        Given user data is seeded
        Then I should be able to create a task using existing account
