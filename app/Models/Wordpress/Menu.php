<?php

namespace App\Models\Wordpress;

use Corcel\Model\Menu as Corcel;

class Menu extends Corcel
{
    protected $connection = 'wordpress';
}
