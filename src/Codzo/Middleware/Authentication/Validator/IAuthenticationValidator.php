<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

interface IAuthenticationValidator
{
    public function __construct(ContainerInterface $ci=null);
    public function isAuthenticated(Request $request=null) : bool  ;
}
