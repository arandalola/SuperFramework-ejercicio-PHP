<?php
    namespace App;
    use \DI\Container;

    class RouterManager{

        private $container;
        public function __construct(Container $container){
            $this->container = $container;
        }

        public function dispatch(string $requestMethod, string $requestUri, \FastRoute\Dispatcher $dispatcher){

            $route=$dispatcher->dispatch($requestMethod, $requestUri);
            \Kint::dump($route);
            switch($route[0]){
                case \FastRoute\Dispatcher::NOT_FOUND:
                    header("HTTP/1.1 404 Not Found");
                    echo "<h1>Not Found</h1>";
                    break;

                case \FastRoute\Dispatcher::FOUND:
                    $controller = $route[1];
                    $method = $route[2];
                    $this->container->call($controller, $method);
                    break;
            }
        }
    }