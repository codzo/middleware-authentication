<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;

class SessionValidator implements IAuthenticationValidator
{
    const SESSION_VARNAME = '_authentication_session_validator_flag';

    public function __construct()
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

    public function isAuthenticated(Request $request=null) : bool
    {
        $config = new Config();
        $varname = $config->get('authentication.sessionvalidator.session.varname');
        $value = $config->get('authentication.sessionvalidator.session.value');
        return $varname
                && key_exists($varname, $_SESSION)
                && $_SESSION[$varname]==$value;
    }
}
