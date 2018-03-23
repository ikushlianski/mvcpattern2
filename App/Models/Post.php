<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 23.03.2018
 * Time: 2:39
 */

namespace App\Models;

use PDO;

class Post extends \Core\Model
{
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->query('SELECT `id`, `title`, `content` FROM `posts` ORDER BY `created_at`');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;

        } catch (\Error $e) {
            echo $e->getMessage();
        }
    }
}