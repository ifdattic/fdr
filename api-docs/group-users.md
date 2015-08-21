# Group Users

Manage users.

## Get token [/users/get-token]

See [authorization](#header-authorization) for how to use the token.

### Get token [POST]

+ Request Get authorization token (application/json)

    + Body

            <!-- include(requests/get-token.json) -->

+ Response 200 (application/json)

        <!-- include(responses/get-token.json) -->

+ Response 401 (application/json)

        <!-- include(responses/unauthorized.json) -->

## Sign-up [/users/sign-up]

### Create a user [POST]

This will create a new user in an application.

**After successful response the application should make a [call for authorization](#users-get-token-post).**

+ Request Create a user (application/json)

    + Body

            <!-- include(requests/sign-up.json) -->

+ Response 201 (application/json)

        <!-- include(responses/signed-up.json) -->

+ Response 400 (application/json)

        <!-- include(responses/sign-up-failed-user-exists.json) -->

+ Request Fail validation (application/json)

    + Body

            <!-- include(requests/sign-up-failed-validation.json) -->

+ Response 400 (application/json)

        <!-- include(responses/sign-up-failed-validation.json) -->

## Current user [/users/me]

Manage an authorized user.

### Get user [GET]

+ Request (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

+ Response 200 (application/json)

        <!-- include(responses/get-user-current.json) -->
