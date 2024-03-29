Feature: A user can delete a task
    In order to plan my week
    As a user
    I need to delete a task

    Scenario: Task is not found
        Given user data is seeded
        Then I should not be able to delete a task which doesn't exist

    Scenario: Task is owned by different user
        Given user data is seeded
        And task data is seeded
        Then I should not be able to delete a task I don't own

    Scenario: Task is deleted
        Given user data is seeded
        And task data is seeded
        Then I should see details of task I own
        And I should be able to delete a task
        And I should not see a task which doesn't exist
