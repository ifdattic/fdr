Feature: A user can update a task
    In order to plan my week
    As a user
    I need to update a task

    Scenario: Task can not be updated without an account
        Then I should not be able to update a task without an account

    Scenario: Task can not be updated if it doesn't exist
        Given user data is seeded
        Then I should not be able to update a task if it doesn't exist

    Scenario: Task can not be updated if different owner
        Given user data is seeded
        And task data is seeded
        Then I should not be able to update a task I don't own

    Scenario: Task can be updated
        Given user data is seeded
        And task data is seeded
        Then I should update a task I own
