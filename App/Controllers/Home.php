<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 19.03.2018
 * Time: 13:58
 */

namespace App\Controllers;

use \Core\View;


class Home extends \Core\Controller
{
    public function indexAction()
    {
        // echo 'Hi from index action in Home controller';
//        View::render('Home/index.php', [
//            'name' => 'Ilya',
//            'colors' => ['red', 'green', 'white']
//        ]);

        View::renderTemplate('Home/index.html', [
            'name' => 'Ilya',
            'colors' => ['red', 'green', 'white']
        ]);
    }

    protected function before()
    {
        // echo "(before) ";
        // some check could be implemented here. If it fails, we return false
        // return false;
    }

    protected function after()
    {
        // echo " (after)";
    }
}