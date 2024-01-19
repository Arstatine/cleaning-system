<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Room;


class UserDataController extends Controller
{
    // display create user data form
    // display room if logged in
    // check if joined in room if user
    public function createForm()
    {
        $rooms = Room::with('members.user')->orderBy('room_number')->get();

        if (auth()->user()) {
            if (auth()->user()->user_type === "admin") {
                return view('welcome', ['rooms' => $rooms]);
            } else {
                $user = User::with(['rooms' => function ($query) {
                    $query->orderBy('room_number');
                }])->find(auth()->id());
                $joined = $user->rooms ?? null;
                return view('welcome', ['rooms' => $rooms, 'joined' => $joined]);
            }
        } else {
            return view('welcome');
        }
    }

    // submit create user data form
    public function submitForm(Request $request)
    {
        // Validation
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'employee_id' => [
                'required',
                Rule::unique('users', 'employee_id')->ignore($request->user())
            ],
            'cp' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($request->user()),
            ],
        ]);

        $validated->sometimes('email', 'unique:users,email', function ($input) {
            return !$input->user();
        });

        $validated->sometimes('employee_id', 'unique:users,employee_id', function ($input) {
            return !$input->user();
        });

        if ($validated->fails()) {
            return redirect()->back()->with('message', 'Email or employee id already registered. Please try again');
        }

        $pass = bcrypt($request->input('birthday'));

        if ($validated) {
            User::create([
                'name' => $request->input('name'),
                'employee_id' => $request->input('employee_id'),
                'birthday' => $request->input('birthday'),
                'cp' => $request->input('cp'),
                'email' => $request->input('email'),
                'password' => $pass,
            ]);
            return redirect('/login');
        }
    }

    // display login form
    public function loginInterface()
    {
        return view('login');
    }

    // login user data
    public function loginForm(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required'],
            'password' => 'required'
        ]);

        if (auth()->attempt($validated)) {
            $request->session()->regenerate();
            if (auth()->user()->user_type === "admin") {
                return redirect('/')->with('message', 'Welcome back admin.');
            }
            return redirect('/')->with('message', 'Welcome back our dear user.');
        }

        return redirect()->back()->with('message', 'Email and password do not not match.')->with('status', 'danger');
    }

    // logout user/admin
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
