<?php

namespace App\Http\Controllers;

use App\Mail\MyEmail;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class ImageController extends Controller
{
    //
    public function upload(Request $request)
    {
        $room_id = $request->input('room_id');
        $user_id = auth()->id();

        $request->validate([
            'image.*' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:5120',
        ]);

        if ($request->hasFile('images')) {
            $uuid = Uuid::uuid4()->toString();

            foreach ($request->file('images') as $image) {
                $path = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $path);

                Image::create(['path' => $path, 'room_id' => $room_id, 'user_id' => $user_id, 'group_id' => $uuid]);
                $imageNams[] = $path;
            }
        }

        return redirect()->back()->withSuccess('You have successfully upload image.')->with('image', $imageNams);
    }

    public function approve(Request $request)
    {
        $group_id = $request->input('group_id');
        Image::where('group_id', $group_id)->update(['approve' => 1]);
        $email = $request->input('email');

        $data = [
            'message' => 'Congratulations, your uploaded image/s has been approved.',
        ];

        Mail::to($email)->send(new MyEmail($data));

        return redirect()->back();
    }

    public function reject(Request $request)
    {
        $group_id = $request->input('group_id');
        $images = Image::where('group_id', $group_id)->get();
        $email = $request->input('email');

        foreach ($images as $image) {
            $filePath = public_path('images/' . $image->path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
        }

        $data = [
            'message' => 'Unfortunately, your uploaded image/s has been rejected.',
        ];

        Mail::to($email)->send(new MyEmail($data));

        return redirect()->back();
    }
}
