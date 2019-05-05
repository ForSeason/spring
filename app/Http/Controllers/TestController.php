<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function path(Request $request) {
        response($request->path());
    }
}
