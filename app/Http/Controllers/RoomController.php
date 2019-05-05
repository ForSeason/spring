<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Room;
use App\Member;

class RoomController extends Controller
{
    public function create(Request $request) {
        $params = array('account', 'members');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->firstOrFail();
            try {
                $nickname = $user->nickname;
                $room = new Room;
                $room->creator = $nickname;
                $room->save();
                $roomID = $room->id;
                foreach($members as $nickname) {
                    $member = new Member;
                    $member->nickname = $nickname;
                    $member->roomID   = $roomID;
                    $member->save();
                }
                return response('', 200);
            } catch (QueryException $e) {
                1 == 1;
            }
        }
        return response(array('message' => '创建房间失败'), 403);
    }

    public function delete(Request $request) {
        $params = array('account', 'room_id');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->firstOrFail();
            $room = Room::where('room_id', $request->room_id)->firstOrFail();
            if ($room->creator == $user->nickname) $status = $room->delete();
            if ($status) return response('', 200);
        }
        return response(array('message' => '删除房间失败'), 403);
    }

    public function getList(Request $request) {
        $user = User::where('account', $request->account)->firstOrFail();
        $list = Member::where('nickname', $user->nickname)->all();
        $result = array();
        foreach($list as $memberInfo) $result[] = $memberInfo['roomID'];
        return response($result);
    }
    //
}
