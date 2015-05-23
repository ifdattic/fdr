Feature: A visitor can log in
    In order to plan my week
    As a visitor
    I need to log in with my account

    Scenario: Successfully login to an existing account
        Given user data is seeded
        Then I should be able to log in as existing user

    Scenario: Trying to log in with wrong password
        Given user data is seeded
        Then I should not be able to log in with wrong password

    Scenario: Trying to log in with non existing account
        Then I should not be able to log in with non existing account

    Scenario: I can see my data after log in
        Given user data is seeded
        Then I should be able to log in as existing user
        Then I should see existing user data
