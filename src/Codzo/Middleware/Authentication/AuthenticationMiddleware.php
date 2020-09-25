<?php
namespace Codzo\Middleware\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Codzo\Config\Config;
use Codzo\Middleware\Authentication\Validator\IAuthenticationValidator;

class AuthenticationMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $config = new Config();
        $classname = $config->get(
            'authentication.validator.classname'
        );
        if(class_exists($classname)) {
            $validator = new $classname($request);

            if($validator instanceof IAuthenticationValidator) {
                if($validator->isAuthenticated()) {
                    $response = $handler->handle($request);
                    return $response;
                }
            }
        }

        $response->getBody()->write('Not permitted');
        return $response;
    }
}
