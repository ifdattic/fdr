# Group Tasks

Manage tasks.

## Task List [/tasks{?from}{to}]

### Get tasks [GET]

Get a list of tasks.

+ Parameters

    + from = `current day` (optional, string, `2015-06-21`) ... Date to return from
    + to = `current day` (optional, string, `2015-06-28`) ... Date to return to


+ Response 200 (application/json)

        <!-- include(responses/tasks-list-with-items.json) -->

+ Response 200 (application/json)

        <!-- include(responses/tasks-list-empty.json) -->

## Create a new task [/tasks]

### Create a task [POST]

+ Request Create a task (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

    + Body

            <!-- include(requests/create-task.json) -->

+ Response 201 (application/json)

        <!-- include(responses/task-created.json) -->

<!-- include(misc/invalid-request-response.md) -->

+ Request Fail validation (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

    + Body

            <!-- include(requests/create-task-failed-validation.json) -->

+ Response 400 (application/json)

        <!-- include(responses/create-task-failed-validation.json) -->

## Tasks [/tasks/{id}]

Manage an existing task.

+ Parameters

    + id (required, string, `5399dbab-ccd0-493c-be1a-67300de1671f`) ... The unique identifier of a task

### Get task [GET]

+ Request (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

+ Response 200 (application/json)

        <!-- include(responses/get-task.json) -->

<!-- include(responses/forbidden.md) -->

<!-- include(responses/task-not-found.md) -->

### Update task [PUT]

+ Request Update task (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

    + Body

            <!-- include(requests/update-task.json) -->

+ Response 200 (application/json)

        <!-- include(responses/task-updated.json) -->

<!-- include(responses/forbidden.md) -->

<!-- include(responses/task-not-found.md) -->

+ Request Fail validation (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

    + Body

            <!-- include(requests/update-task-failed-validation.json) -->

+ Response 400 (application/json)

        <!-- include(responses/update-task-failed-validation.json) -->

### Delete task [DELETE]

+ Request (application/json)

    + Headers

            <!-- include(headers/authorized.md) -->

+ Response 200 (application/json)

        <!-- include(responses/delete-task.json) -->

<!-- include(responses/forbidden.md) -->

<!-- include(responses/task-not-found.md) -->
