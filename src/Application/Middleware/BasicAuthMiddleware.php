<?php
// Path: src/Application/Middleware/BasicAuthMiddleware.php
declare(strict_types=1);
/**
 * HTTP Basic Authentication Middleware
 *  HTTP provides a general framework for access control and authentication.
 */
namespace Rcsvpg\Murls\Application\Middleware;

use Slim\Middleware;

/**
 * The general HTTP authentication framework
 *
 *  RFC 7235 defines the HTTP authentication framework, which can be used by
 * a server to challenge a client request, and by a client to provide
 * authentication information.
 *
 * The challenge and response flow works like this:
 *
 * 1. The server responds to a client which a 401 (Unauthorized) response
 *    status and provides information on how to authroize with a
 *    `WWW-Authenticate` response header containing at least one challenge.
 * 2. A client that wants to authenticate itself with the server can then
 *    do so by including an `Authorization` request header with the
 *    credentials.
 * 3. Usually a client will present a password prompt to the user and
 *    will then issue the request including the correct `Auhtorization`
 *    header.
 *
 * The general message flow above is the same for most (if not all)
 * authentication schemes. The actual information in the headers and the
 * wat it is encoded does change!
 *
 * ```
 * AuthType Basic
 * AuthName "Access to the staging site"
 * AuthUserFile /path/to/.htpasswd
 * Require valid-user
 * ```
 */
class BasicAuthMiddleware extends Middleware
{
  
  /**
   * @var $auth_name string represents "AuthName"
   */
  protected $realm ;
  
  /**
   * @var $username string
   */
  protected $username ;
  
  /**
   * @var $password string
   */
  protected $password ;
  
  public function __construct($username, $password, $realm = 'Protected Area')
  {
    $this->username = $username;
    $this->password = $password;
    $this->realm = $realm ;
  }
  
  // call
  public function call()
  {
    //
    $request = $this->app->request() ;
    $response = $this->app->response() ;
    
    $auth_user = $request->headers('PHP_AUTH_USER');
    $auth_pass = $request->headers('PHP_AUTH_PW');
    
    if ($auth_user && $auth_pass &&
        $auth_user === $this->username &&
        $auth_pass === $this->password) {
      
      $this->next->call() ;
    } else {   
      $response->status(401);
      $response->header('WWW-Authenticate', sprintf('Basic realm="%s", charset="UTF-8"', $this->realm));
  }
}
  
