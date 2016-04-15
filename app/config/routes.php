<?php

/*
 * --------------------------------------------------------------------------
 * CONTROLADORES
 * --------------------------------------------------------------------------
 *
 * Você DEVE definir o nome que será usado na url para acessar cada
 * controlador da sua aplicação.
 *
 * $router->controller(name, controller)
 */
$router->controller('home', 'Home');
$router->controller('list', 'Todo');

/*
 * --------------------------------------------------------------------------
 * MÉTODOS
 * --------------------------------------------------------------------------
 *
 * Você pode definir uma url mais amigável para acessar um método específico
 * do controlador quando desejado.
 *
 * $router->controllerMethod(name, controller@method)
 */

$router->controllerMethod('todo.create' , 'Todo@create');
$router->controllerMethod('todo.remove' , 'Todo@remove');
$router->controllerMethod('todo.update' , 'Todo@update');
$router->controllerMethod('todo.edit'   , 'Todo@edit');
$router->controllerMethod('todos'       , 'Todo@getAll');