<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$module_name = explode("/", str_replace("test_app",'',$_SERVER['REQUEST_URI']));
$controller = $module_name[2];
$action = $module_name[3];

// echo"<pre>";
// print_r($module_name);
// exit;

if(strpos($module_name[3],'?') !==false){
    $action_arr = explode("?", $module_name[3]);
    $action = $action_arr[0];
    
}

$routes->get('/'.$controller.'/'.$action.'', ''.ucfirst($controller).'::'.$action.'');
$routes->post('/'.$controller.'/'.$action.'', ''.ucfirst($controller).'::'.$action.'');





// $routes->get('/user/list', 'User::list');
// $routes->get('/user/add', 'User::add');
// $routes->post('/user/add', 'User::add');
// $routes->get('/user/manageData', 'User::manageData');
// $routes->post('/user/manageData', 'User::manageData');