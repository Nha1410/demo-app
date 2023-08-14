<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /*
    ** show template for create new post
    */
    public function create() {
        return Inertia::render('Post/Create', []);
    }
    /*
    ** get list post and paginate 
    */
    public function getList() {
        
    }
}
