<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;

class SessionValidator implements IAuthenticationValidator
{
    const SESSION_VARNAME = '_authentication_session_validator_flag';

    public function __construct(Request $request=null)
    {
    }

    public function isAuthenticated() : bool
    {
        return key_exists($_SESSION[self::SESSION_VARNAME])
            && $_SESSION[self::SESSION_VARNAME];
    }

    public function authenticate() : self
    {
        $_SESSION[self::SESSION_VARNAME] = true;

        return $this;
    }

    public function revoke() : self
    {
        unset($_SESSION[self::SESSION_VARNAME]);

        return $this;
    }
}
