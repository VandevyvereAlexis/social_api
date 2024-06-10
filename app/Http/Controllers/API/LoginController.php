<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Tenter la connexion utilisateur
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login (Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Laravel tente de connecter si l'email existe ET si le password en clair correspond à celui hashé
        if (Auth::attempt($credentials))
        {
            // Si la connexion fonctionne, on récupère l'utilisateur et on charge son rôle
            $authUser = User::find(Auth::user()->id)->load('role');

            // on renvoie la réponse
            return response()->json([$authUser, 'Vous êtes connecté']);
        } else
        {
            // si echec de la connexion, on renvoie un message d'erreur
            return response()->json(['Echec de la connexion', 'errors' => 'L\'utilisateur n\'existe pas ou le mot de passe est incorrect']);
        }
    }





    /**
     * Tenter la connexion utilisateur
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // déconnecte de la session en cours et invalide le token du cookie de session
        Auth::guard('web')->logout();

        return response()->json([
            'status'  => true,
            'message' => 'Déconnexion réussie',
        ]);
    }
}
