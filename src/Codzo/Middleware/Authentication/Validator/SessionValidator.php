<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Codzo\Config\Config;

class SessionValidator implements IAuthenticationValidator
{
    const DEFAULT_SESSION_KEY     = 'AUTHENTICATION_IDENTIFIER';
    const DEFAULT_SESSION_PATTERN = '.+';

    protected $containeri;

    public function __construct(ContainerInterface $ci=null)
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

        $this->container = $ci;
    }

    public function isAuthenticated(Request $request=null) : bool
    {
        $config = new Config();
        $key = $config->get(
            'authentication.sessionvalidator.key',
            static::DEFAULT_SESSION_KEY
        );
        $pattern = $config->get(
            'authentication.sessionvalidator.pattern',
            static::DEFAULT_SESSION_PATTERN
        );
        return $key
                && key_exists($key, $_SESSION)
                && preg_match(
                    '/'.$pattern.'/',
                    $_SESSION[$key]
                );
    }
}
