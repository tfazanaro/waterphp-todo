<?php namespace core\routing\Router\tests;

use core\routing\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetRoutes()
    {
        $this->router->controller('user.my-test', 'User');
        $this->router->controller('user-test.xxx123', 'User');
        $this->router->controller('user_testx_testy', 'User');

        $this->router->controllerMethod('user.create', 'User@store');
        $this->router->controllerMethod('user.remove', 'User@destroy');

        $routes = $this->router->getRoutes();
        $bool = (is_array($routes) and count($routes) > 0);

        $this->assertTrue($bool);
    }

    public function testGetController()
    {
        $controller = $this->router->getController();

        $this->assertNull($controller);
    }

    public function testGetMethod()
    {
        $method = $this->router->getMethod();

        $this->assertNull($method);
    }

    public function testGetParams()
    {
        $params = $this->router->getParams();

        $this->assertNull($params);
    }
}