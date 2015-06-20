Feature: A user can view tasks
    In order to plan my week
    As a user
    I need to see details of tasks

    Scenario: Task is not found
        Given user data is seeded
        Then I should not see a task which doesn't exist

    Scenario: Task is owned by different user
        Given user data is seeded
        And task data is seeded
        Then I should not be able to see a task I don't own

    Scenario: Task details can be viewed
        Given user data is seeded
        And task data is seeded
        Then I should see details of task I own

    Scenario: User has no tasks
        Given user data is seeded
        Then I should not get any tasks if I don't have them

    Scenario: User tasks are returned
        Given user data is seeded
        And task data is seeded
        Then I should get a list of my tasks
