<?php

namespace App\Http\Controllers;

use App\Saying;
use App\User;
use Illuminate\Http\Request;

class SayingController extends Controller
{
    public function create(Request $request) {
        $params = array('content', 'account');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->firstOrFail();
            try {
                $saying = new Sayings;
                $saying->user_id      = $user->id;
                $saying->nickname     = $user->nickname;
                $saying->url_head_pic = $user->url_head_pic;
                $saying->content      = $request->content;
                $saying->save();
                return response('');
            } catch (QueryException $e) {
                return response($e);
            }
        }
        return response(array('message' => '发送失败'), 403);
    }

    public function showAll() {
        return response(Saying::all());
    }
}
