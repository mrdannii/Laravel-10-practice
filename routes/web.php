<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;

use Illuminate\Support\Facades\Route;
use App\Models\User;

use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // $a=User::where('id',2)->first();
    // dd($a);
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');

    Route::post('/profile/avatar/ai', [AvatarController::class, 'generate'])->name('profile.avatar.ai');

});

require __DIR__.'/auth.php';


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
}) ->name('github.login');

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    if($githubUser->name == NULL)
    {
        $xname= Str::random(7);
    }
    else{
        $xname= $githubUser->name;
    }

    $user = User::firstOrCreate(['email' => $githubUser->email, ],[
    'name' => $xname,
     'password' => 'password',
 ]);

    Auth::login($user);
    return redirect('/dashboard');

    //dd($githubUser);
    // $user->token
});
