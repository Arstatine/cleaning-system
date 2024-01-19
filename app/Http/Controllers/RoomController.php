<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Members;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{

    // display room
    public function index()
    {
        return view('admin.addroom');
    }

    // display one room using id number
    public function showRoom($id)
    {
        $result = Room::with('members.user')->find($id);
        $joined = false;
        foreach ($result->members as $member) {
            if ($member->user_id == auth()->id()) {
                $joined = true;
            }
        }
        $members = $result->members;

        if (auth()->user()->user_type == 'admin') {
            $images = Image::with('user')
                ->where('room_id', $id)
                ->get()
                ->groupBy('group_id');

            return view('admin.room', ['data' => $result, 'members' => $members, 'id' => $id, 'joined' => $joined, 'images' => $images]);
        } else {
            $images = Image::where('room_id', $id)
                ->where('user_id', auth()->id())
                ->get()
                ->groupBy('group_id');
            $user = User::where('id', auth()->id())->first();
            return view('admin.room', ['data' => $result, 'members' => $members, 'id' => $id, 'joined' => $joined, 'images' => $images, 'user' => $user]);
        }
    }

    // create one room
    public function createRoom(Request $request)
    {
        // Validation
        $validated = Validator::make($request->all(), [
            'room_number' => [
                'required',
                Rule::unique('rooms', 'room_number')->ignore($request->user())
            ],
            'room_name' => 'required',
            'capacity' => 'required'
        ]);

        $validated->sometimes('room_number', 'unique:rooms,room_number', function ($input) {
            return !$input->user();
        });

        if ($validated->fails()) {
            return redirect()->back()->with('message', 'Room number already added.');
        }


        if ($validated) {
            Room::create([
                'room_number' => $request->input('room_number'),
                'room_name' => $request->input('room_name'),
                'capacity' => $request->input('capacity')
            ]);
            return redirect('/')->with('message', 'Room successfully created.');
        }
    }

    // display all members available
    public function showMembers($id)
    {
        $result = Room::with('members.user')->find($id);
        $members = $result->members;

        $users = User::where('user_type', 'user')->get();
        return view('admin.addmember', ['data' => $result, 'members' => $members, 'id' => $id, 'users' => $users]);
    }

    // add members to room
    public function addMembers(Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('employee_id');

        $result = Room::with('members.user')->find($id);
        $members = $result->members;

        $memberCounts = Members::where('room_id', $id)
            ->groupBy('room_id')
            ->selectRaw('room_id, count(*) as count')
            ->get();
        $room = Room::where('id', $id)->first();

        if (count($memberCounts) >= $room->capacity) {
            return redirect()->back()->with('message', 'Room is full.');
        }

        $result = Room::with('members.user')->find($id);
        $joined = false;
        foreach ($result->members as $member) {
            if ($member->user_id == $user_id) {
                $joined = true;
            }
        }

        if ($joined) {
            return redirect()->back()->with('message', 'Member already added.');
        }

        $result = Room::with('members.user')->find($id);
        $joined = false;
        foreach ($result->members as $member) {
            if ($member->user_id == auth()->id()) {
                $joined = true;
            }
        }
        $members = $result->members;

        Members::create([
            'room_id' => $id,
            'user_id' => $user_id,
        ]);

        return redirect('/room/' . $id)->with(['data' => $result, 'members' => $members, 'id' => $id, 'joined' => $joined]);
    }
}
