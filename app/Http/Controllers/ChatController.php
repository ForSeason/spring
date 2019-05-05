<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Member;
use App\Chat;

class ChatController extends Controller
{
    public function getChats(Request $request) {
        return response($request->all());
        $user = User::where('account', $request->account)->firstOrFail();
        $result = Chat::with('user')->where('user_id', $user->id)->orderBy('create_at', 'desc')->limit(100)->get();
        return response($result);
    }

    public function postText(Request $request, $room_id) {
        $params = array('account', 'content');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->firstOrFail();
            if (self::inRoom($user->id, $room_id)) {
                $chat = new Chat;
                $chat->type     = 'text';
                $chat->content  = $request->content;
                $chat->room_id  = $room_id;
                $chat->user_id  = $user->id;
                $chat->save();
                return response('');
            } else {
                return response(array('message' => '你不在当前聊天中！'), 403);
            }
        }
        return response(array('message' => '聊天发送失败'), 403);
    }

    public function postMedia(Request $request, $room_id, $type) {
        $params = array('account', 'picture');
        if ($request->has($params)) {
            if (!in_array($type, array('picture', 'audio'))) {
                return response(array('message' => 'type参数错误！'), 403);
            }
            $user = User::where('account', $request->account)->firstOrFail();
            if (self::inRoom($user->id, $room_id)) {
                $filename = upload($request, $type);
                $chat = new Chat;
                $chat->type     = $type;
                $chat->content  = $filename;
                $chat->user_id  = $user->id;
                $chat->room_id  = $room_id;
                $chat->save();
                return response('');
            } else {
                return response(array('message' => '你不在当前聊天中！'), 403);
            }
        }
        return response(array('message' => '聊天发送失败'), 403);
    }

    function inRoom($user_id, $room_id) {
        return !empty(Member::where('user_id', $user_id)
            ->where('room_id', $room_id)
            ->first()
        );
    }

    function upload($request, $type) {
        $fileHandler = $request->file($type);
        $exts = array(
            'picture' => array('jpg', 'jpeg', 'png'),
            'audio'   => array('mp3', 'wav', 'frac'),
        );
        if ($fileHandler->isValid()) {
            $ext  = $fileHandler->getClientOriginalExtension();
            if (in_array($ext, $exts[$type])) {
                $path = $fileHandler->getRealPath();
                $filename = '/storage/app/public/'.$type.'/'.md5(time()).'.'.$ext;
                Storage::disk('public')->put($filename, file_get_contents($path));
                return response($filename);
            }
        }
        return null;
    }
}
