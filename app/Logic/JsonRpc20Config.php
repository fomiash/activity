<?php

declare(strict_types=1);

namespace App\Logic;


class JsonRpc20Config
{
    const AUTH_ERROR = 300;
    const REQUEST_ERROR = 400;
    const SERVER_ERROR = 500;
    const UNDEFINED_ERROR = 900;

    const RPC_ERRORS = [
        self::AUTH_ERROR => 'Authorisation Error',
        self::REQUEST_ERROR => 'Error in request',
        self::SERVER_ERROR => 'Server error',
        self::UNDEFINED_ERROR => 'Unidentified error'
    ];
}
