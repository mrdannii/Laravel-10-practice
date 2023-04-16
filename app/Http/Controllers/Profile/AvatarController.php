<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use OpenAI\Laravel\Facades\OpenAI;



class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        if ($oldavatar = $request->user()->avatar) {
            Storage::disk('public')->delete($oldavatar);
        }
        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        //  $path = $request->file('avatar')->store('avatars','public');
        Auth::user()->update(['avatar' => $path]);
        return redirect('/profile')->with('status', 'avatar-updated');
    }

    public function generate(Request $request)
    {


        $result = OpenAI::images()->create([
            "prompt" => "create avatar for user Profile animated related to tech",
            "n" => 1,
            "size" => "256x256"
        ]);

        if ($oldavatar = $request->user()->avatar) {
            Storage::disk('public')->delete($oldavatar);
        }
        $content = file_get_contents($result->data[0]->url);
        $filename = Str::random(25);
        Storage::disk('public')->put("avatars/$filename.jpg", $content);


        Auth::user()->update(['avatar' => "avatars/$filename.jpg"]);


        return redirect('/profile')->with('status', 'avatar-generated');

    }
}
