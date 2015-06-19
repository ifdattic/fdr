Feature: A visitor can sign up
    In order to plan my week
    As a visitor
    I need to sign up for an account

    Scenario: Sign up for an account
        When I sign up with available email
        And I should be able to log in as newly created user

    Scenario: Email address is already taken
        Given user data is seeded
        When I sign up with email which is taken
        Then I should receive bad request response
