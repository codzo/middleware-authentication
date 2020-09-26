<?php

namespace Codzo\Middleware\Authentication\Validator;

use Psr\Http\Message\ServerRequestInterface as Request;

interface IAuthenticationValidator
{
    public function __construct(Request $request=null);
    public function isAuthenticated() : self  ;
    public function authenticate() : self ;
    public function revoke() : self ;
}
