<?php

namespace App\Http\Controllers;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
      $user = Auth::user();
      $contents = $user->contents;
      return view('dashboard.dashboard', compact('user', 'contents'));
   }
}
