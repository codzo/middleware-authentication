<?php
namespace Codzo\Middleware\Authentication;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Codzo\Config\Config;
use Codzo\Middleware\Authentication\Validator\IAuthenticationValidator;

class AuthenticationMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
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

        $response = new Response();
        $redirect_url = $config->get("authentication.redirect.url", '/login');
        return $response
            ->withHeader('Location', $redirect_url)
            ->withStatus(302);
    }
}
