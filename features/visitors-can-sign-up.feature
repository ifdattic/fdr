Feature: A visitor can sign up
    In order to plan my week
    As a visitor
    I need to sign up for an account

    Scenario: Sign up for an account
        When I sign up with email "virgil@mundell.com", full name "Virgil Mundell" and password "topsecret"
        Then I should be able to log in with email "virgil@mundell.com" and password "topsecret"

    Scenario: Email address is already taken
