<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;

class SessionValidator implements IAuthenticationValidator
{
    const SESSION_VARNAME = '_authentication_session_validator_flag';

    public function __construct(Request $request=null)
    {
        $status = session_status(); 
        if($status == PHP_SESSION_DISABLED) {
            throw new \Exception('session disabled, can not validate');
        }

        if($status == PHP_SESSION_NONE ) {
            if(!session_start()) {
                throw new \Exception('Failed to init session, can not validate');
            }
        }
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
