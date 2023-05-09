<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $data = User::get();
        // return $user;
        return view('users', compact('data'));
    }

    public function delete($id)
    {
        User::where('id','=',$id)->delete();
        return redirect()->back();
    }
}
