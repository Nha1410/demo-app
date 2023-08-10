<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, Authorizable;
}
