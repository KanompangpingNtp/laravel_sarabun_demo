<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.show_form_login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'name_account' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['name_account' => $request->name_account, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->agencie_id == 1) {
                return redirect()->route('getbookIndex');
            } elseif ($user->agencie_id == 2) {
                return redirect()->route('routeForAgency2');
            } elseif ($user->agencie_id == 3) {
                return redirect()->route('routeForAgency3');
            }
        }

        return back()->withErrors([
            'name_account' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLoginForm');
    }
}
