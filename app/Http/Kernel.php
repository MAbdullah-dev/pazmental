<?php

namespace App\Http;

class Kernel
{
    protected $routeMiddleware = [
        // Other middleware...
        'site_access' => \App\Http\Middleware\RestrictSiteAccess::class,
    ];
}
