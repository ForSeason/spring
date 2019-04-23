<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class UserController extends Controller
{
    public function login(Request $request) {
        $params = array('account', 'password');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->firstOrFail();
            $user->token = password_hash(time(), PASSWORD_DEFAULT);
            $user->update();
            if ($user && password_verify($request->password, $user->password)) return response($user, 200);
        }
        return response(array('message' => '用户名或密码错误'), 401);
    }

    public function register(Request $request) {
        $params = array('account', 'password', 'nickname');
        if ($params == array_keys($request->input())) {
            try {
                $user = new User;
                $user->account  = $request->account;
                $user->password = password_hash($request->password, PASSWORD_DEFAULT);
                $user->nickname = $request->nickname;
                $user->save();
                return response('', 200);
            } catch (QueryException $e) {
                1 == 1;
            }
        }
        return response(array('message' => '该账户名已被占用'), 403);
    }

    public function patch(Request $request) {
        if ($request->has('account')) {
            $params = array('nickname', 'url_head_pic', 'sex', 'phone', 'age');
            $input  = $request->input();
            try {
                $user = User::where('account', $request->account)->firstOrFail();
                foreach ($input as $k => $v) if (in_array($k, $params)) $user->$k = $v;
                $user->save();
                return response('', 200);
            } catch (QueryException $e) {
                1 == 1;
            }
        }
        return response(array('message' => '用户信息更新失败'), 403);
    }

    public function upload_head_pic(Request $request) {
        $fileHandler = $request->file('head_pic');
        if ($fileHandler->isValid()) {
            $ext  = $fileHandler->getClientOriginalExtension();
            if (in_array($ext, array('jpg', 'jpeg', 'png'))) {
                $path = $fileHandler->getRealPath();
                $filename = '/storage/app/public/'.date('Y-m-d-h-i-s').'.'.$ext;
                Storage::disk('public')->put($filename, file_get_contents($path));
                return response(array('url_head_pic' => $filename));
            }
        }
        return response(array('message' => '上传头图失败'), 403);
    }
}
