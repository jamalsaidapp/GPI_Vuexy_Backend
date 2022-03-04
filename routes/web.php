<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd('server Runing...');
//    $role  = Role::findByName('admin');
//        $user =  User::create([
//        'first_name'=> 'Jamal',
//        'last_name'=> 'Said',
//        'username'=> 'said.jamal',
//        'email'=> 'said.jamal@nomatis.com',
//        'password'=> \Hash::make('jssjjamalsaid'),
//        'status' => true
//    ]);
    // $user = User::findOrFail(1);
    // $user->assignRole('admin');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//require __DIR__.'/auth.php';
