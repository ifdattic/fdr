<?php

namespace Domain\Core\Spec;

/**
 * Class this contains the values used in tests.
 */
final class TestValues
{
    const COMPLETED_DATE  = '2015-04-15 13:14:15';
    const COMPLETED_DATE2 = '2015-06-15 17:34:55';

    const DATE  = '2015-04-15';
    const DATE2 = '2015-06-05';

    const DESCRIPTION  = 'This is the description.';
    const DESCRIPTION2 = 'Alternative description';

    const EMAIL         = 'virgil@mundell.com';
    const EMAIL2        = 'john@doe.com';
    const EMAIL3        = 'alice@carlton.com';
    const INVALID_EMAIL = 'invalid@email';

    const ESTIMATE  = 3;
    const ESTIMATE2 = 2;

    const FULLNAME  = 'Virgil Mundell';
    const FULLNAME2 = 'John Doe';
    const FULLNAME3 = 'Alice Carlton';

    const IMPORTANT     = true;
    const NOT_IMPORTANT = false;

    const INVALID_NON_STRING_PASSWORD = 1234567890;
    const PASSWORD                    = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';
    const PASSWORD2                   = '%XIIPqR2j*mEF^DNuQg1JIKXt2Dzej';
    const TOO_SHORT_PASSWORD          = 'short';

    const INVALID_LENGTH_PASSWORD_HASH = '$2y$14$2RfLwLL./bzTyfNdBRaote';
    const PASSWORD_HASH                = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';
    const PASSWORD_HASH2               = '$2y$14$WP8RXsprmipbMYe867YLmOEErWlZjlndcYijPT.swBodoHEdGWEU2';

    const TASK_NAME  = 'Task Name';
    const TASK_NAME2 = 'Task Name Alternative';

    const TIME_SPENT  = 23;
    const TIME_SPENT2 = 22;

    const INVALID_UUID = '123';
    const UUID         = '5399dbab-ccd0-493c-be1a-67300de1671f';
    const UUID2        = '97fd781e-35c5-4b8e-9175-3ae730d86bdb';
    const UUID3        = 'df603d36-1203-4bc5-9cd8-99c775ac272a';

    private function __construct()
    {
    }
}
