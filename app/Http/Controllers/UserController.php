<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
  public function index(User $user)
  {

    return view('user.profile', [
      'user' => $user,
    ]);
  }
}
