<?php

namespace App\Models\Wordpress;

use Corcel\Model\Post as Corcel;

class Post extends Corcel
{
    protected $connection = 'wordpress';

}
