<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  /**
   * 1. show user registration form
   */
  public function AddUserForm(){
    return view('users.register');
  }

  /**
   * 2. manage user registration form
   */
  public function AddUser(Request $request){
    $validated = $request->validate([
      'name'  => 'required|string|max:200',
      'email' => 'required|string|email|max:200|confirmed|unique:users,email',
      'password' => 'required|string|min:12|confirmed',
    ]);

    $newUser = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'country_iso3' => "ITA",
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    Auth::login($newUser);

    return redirect()
      ->route('userHome', [ 'id' => $newUser['id'] ] )
      ->with('success', 'Registrazione utente '. $validated['name'] . ' id: '. $newUser['id'] . ' effettuata.');
    
  }

  /**
   * 3. extract user data - single 
   */
  // ? input è una Request ? o una string ?
  public function UserData(string $id = '') {

    $youAre = User::where('id', $id)->first();
    if ($youAre === false){
      return redirect()
        ->route('addUserForm' )
        ->with('error', 'User not found. New registration?');
    }

    return view('users.home', ['youAre' => $youAre ]);
  }

  /**
   * 4. login
   */
  public function LoginFormView() {
    Auth::logout();

    return view('auth.login');
  }
  public function LoginValidateForm(Request $request) {
    $validated   = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);
    if (Auth::attempt($validated)) {
      $request->session()->regenerate();
      return redirect()->route('userHome', ['id' => Auth::id() ]);
    }
    // ouch
    throw ValidationException::withMessages([
      'credentials' => 'Sorry, incorrect credentials.',
    ]);
  }

  public function LogoutValidateForm(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('welcome');
  }

  /**
   * 
   */

}
