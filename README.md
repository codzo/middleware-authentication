# Authenticate Through Middleware

## Dependency

* Package `codzo/config`

## Settings

Require following settings exposured to `codzo/config`

* `authentication.validator.classname`

    The classname of selected validator. If appointing multiple validators, using a comma to separate class names. The first validator successfully authenticated the use will provide an authentication identifier to app and end the process.

    Provide full class name with namespaces.

    Default value: `Codzo\Middleware\Authentication\Validator\SessionValidator`.

    
* `authentication.redirect.url`

    The redirect url when authentication failed. 
    
    Default value: `/login`.

See validators for more setting options.

## How to authenticate

This middleware will call **validators** to authenticate.
A validator implements `IAuthenticationValidator` providing following functions:

* `isAuthenticated(Request $request=null) : bool`

    check if authenticated. If not, redirect to `/Login'

* `getAuthenticationIdentifer() : string`

    get the identifier. See validators for specific data returned.

## Validator

Built-in validators:

### SessionValidator

Validate the data stored in session for authentication.

Settings:
* `authentication.sessionvalidator.session.varname`

    The name of the session data. This is the key name of `$_SESSION` variable.

    Example:

    With setting as of `LOGIN_UUID`, `$_SESSION ['LOGIN__UUID']` will be checked and returned.

* `authentication.sessionvalidator.session.value`

    The pattern of the expected identifier. If session data matches this pattern, current use will be considered as authenticated.

    Example: 
    `.*` to match any string.