<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 20.03.2018
 * Time: 1:27
 */

namespace Core;


class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = '../App/Views/'.$view; // relative to Core dir

        if (is_readable($file)) {
            require $file;
        } else {
            // echo "{$file} not found";
            throw new \Exception("{$file} not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}