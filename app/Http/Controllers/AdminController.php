<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function users()
    {
        return view('admin.users');
    }

    public function articles()
    {
        return view('admin.articles');
    }
}
