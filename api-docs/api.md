FORMAT: 1A
HOST: https://api.example.com

# FDR API

## Generating documentation

The documentation is rendered using [aglio](https://github.com/danielgtaylor/aglio).

The command for rendering from root (the file must be on web server path to function correctly):

```bash
aglio -i api-docs/api.md -o web/api.html
```

The following command can be used to have preview documentation when writing it:

```bash
aglio -i api-docs/api.md -s
```

The documentation file should **not** be available on **production server** for security reasons.

## Authorization

Most endpoints in the API will require the `Authorization` HTTP header.

```http
Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9.eyJleHAiOjE0NDAxNDA5MTYsInVzZXJuYW1lIjoidmlyZ2lsQG11bmRlbGwuY29tIiwiaWF0IjoiMTQzMjM2NDkxNiJ9.KehFCfleQ7JAYnWpd55svIbMHS-EcbQdZyQm-oCfoYlSf3ABA04vMp0F6mGoxWmuK35UE6y4vr8vta0DWhhFuvgGkbF-DQLuJV6j5KbsseKLPRIjnlo8rKlg8tjNShw6aTroxO59Ee-rWBycTLGjNQRWUah_zk-QYm43gavtWaJRa-hc1cTmFFajgs83Jy3psidt320l3N74tWoJDPgcSWwUY83jVLY5IGvFf0ZaiRolCbC4aKGsdND8m2BIlFDp6-MNBAnImV0LELDQsKqlqENjFpohIIrUdzRRBz76Z-i0lRmz4XwxroS_GhYHmt098y-KzptSC7wuwpoMhfa1nV0FS9bJ2X_ZCtFaWjrJPBN-hw74p91nM0Fixw07pynGS2ennyeS5heuubURia75AZds83ihjPa4BgBLBYwnVBDvzPteYN3UTmyBXmFBAHmNX4BhljqAmkjUrY6GlrfRh8yGKQIqbW2tsCrhXiZ5-aChhe1x87qKYCOVZlSXjb6-0Lyh9-I7fjaWKK2IdtlEfyQzIJVa2zp98I6GMXlaUyHeSC0AWNdVb6OwfU-NoFlI1qu4GVbHL9HuE1l2sjHQjj_3_fXGJ_FKDz4k5afXh_bhfrJucNLm_7BNjMyk1gVnrritk1zZJoSr-5cC2LaBJdPoMPvz9dxD6H50gr7Ff-8
```

Failing to do so will cause the following error:

```json
{
  "code": 401,
  "message": "Invalid credentials"
}
```

To get the token make a [call for authorization](#users-get-token-post).

## Invalid requests

When making invalid/bad calls to an API (for example `POST` without JSON data) the API will return a response explaining that request is bad.

See [task creation](#tasks-create-a-new-task-post) for an example.

<!-- include(group-tasks.md) -->

<!-- include(group-users.md) -->
