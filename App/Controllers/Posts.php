<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 19.03.2018
 * Time: 12:30
 */

namespace App\Controllers;

use \Core\View;
use \App\Models\Post;

class Posts extends \Core\Controller
{
    public function indexAction()
    {

        $posts = Post::getAll();
        // echo 'Hello from index action in Posts controller';
        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);
    }

    public function addNewAction()
    {
        echo 'Hello from AddNew action in Posts controller';
    }

    public function editAction()
    {
        echo 'Hello from EDIT action in Posts controller';
        echo '<p>Route parameters: <pre>'.
            htmlspecialchars(print_r($this->route_params, true)).'</pre></p>';
    }
}