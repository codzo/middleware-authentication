<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;

interface IAuthenticationValidator
{
    public function __construct();
    public function isAuthenticated(Request $request=null) : bool  ;
}
