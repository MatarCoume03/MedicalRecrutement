<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants incorrects'
            ], 401);
        }
    
        $user = Auth::user();
        $token = $user->createToken('API_TOKEN')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token  // Assurez-vous que ce champ existe
        ]);

       /* $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);*/
    }

    public function showAccountTypeSelection()
    {
        return view('auth.register-type');
    }

    public function showRegistrationForm(Request $request)
    {
        $type = $request->query('type');
        
        if (!in_array($type, ['candidat', 'recruteur'])) {
            return redirect()->route('register.type');
        }

        return view('auth.register', compact('type'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => 'required|in:candidat,recruteur',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        if ($request->type === 'candidat') {
            $user->candidatProfil()->create([]);
        } else {
            $user->recruteurProfil()->create([]);
        }

        Auth::login($user);

        return redirect($this->redirectPath());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function redirectPath()
    {
        $user = auth()->user();
        
        if (!$user) {
            return route('login');
        }

        // Debug: Vérifiez le type utilisateur
        \Log::info('User Type: '.$user->type);
        
        // Redirection basée sur le type
        switch ($user->type) {
            case 'admin':
                return route('admin.dashboard');
            case 'recruteur':
                return route('recruteur.dashboard');
            case 'candidat':
                return route('candidat.dashboard');
            default:
                \Log::error('Type utilisateur inconnu: '.$user->type);
                return route('accueil');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}