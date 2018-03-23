<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 19.03.2018
 * Time: 2:21
 */

namespace Core;

class Router
{
    protected $routes = [];

    // parameters from the matched route
    // for example [controller] => posts [action] => add-new
    protected $params = [];

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    // echo "Method {$action} (in controller {$controller}) not found";
                    throw new \Exception("Method {$action} (in controller {$controller}) not found");
                }
            } else {
                // echo "Controller class $controller not found";
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            // echo "No route matched";
            throw new \Exception("No route matched", 404);
        }
    }

    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    // $params is controller and action
    public function add($route, $params = [])
    {
        // convert route into a regex: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variable with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiers and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function match($url)
    {
        // based on $url we look up our routing table
//        foreach($this->routes as $route => $params) {
//            if ($url == $route) {
//                $this->params = $params;
//                return true;
//            }
//        }
//        return false;

        // Match to the fixed URL format
        // $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // $params = [];

                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    public function getParams()
    {
        return $this->params;
    }

    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}