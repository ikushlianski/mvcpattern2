<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
    protected function before()
    {
        // For example make sure admin is logged in
        // return false;
    }


    public function indexAction()
    {
        echo 'User admin index';
    }
}