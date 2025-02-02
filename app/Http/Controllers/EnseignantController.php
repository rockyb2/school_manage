<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignant;

class EnseignantController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('enseignant')) {
            return redirect()->route('dashboard');
        }
        return view('enseignant.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mot_de_passe' => 'required',
        ]);

        $enseignant = Enseignant::where('mot_de_passe', $request->mot_de_passe)->first();

        if ($enseignant) {
            $request->session()->put('enseignant', $enseignant);
            return redirect()->route('dashboard');
        }

        return back()->withInput()->withErrors([
            'mot_de_passe' => 'Le mot de passe ne correspond pas',
        ]);
    }

    public function dashboard()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }
        return view('enseignant.dashboard', compact('enseignant'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('enseignant');
        return redirect('/');
    }
}
