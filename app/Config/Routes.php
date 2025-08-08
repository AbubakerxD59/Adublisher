<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//$routes->get('/', 'Home::index');

//$routes->get('/', 'Welcome::index');

$routes->get('/login', 'publisher\Home::login_view');

//$routes->get('blog/(:any)', 'Publisher\Home::blog_inner_view/$1');
//
//$routes->get('link/(:any)/(:any)', 'Rest\Publisher\Usersrest::url_redirect/$1/$2');