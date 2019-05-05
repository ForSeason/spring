<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function path(Request $request) {
        return response(array(
            'status' => 'ok',
            'path' => $request->path(),
            'url' => action('RoomController@create')
        ));
    }
}
