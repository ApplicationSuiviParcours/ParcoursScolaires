<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentEleve;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
'role' => ['required', 'string', 'in:eleve,parent,enseignant'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_active' => true,
        ]);

        // Assigner le rôle sélectionné par l'utilisateur
        $user->assignRole($data['role']);

        // Create profile record based on role
        $nameParts = explode(' ', trim($data['name']));
        $prenom = $nameParts[0] ?? 'Utilisateur';
        $nom = implode(' ', array_slice($nameParts, 1)) ?: 'Utilisateur';

        switch ($data['role']) {
            case 'enseignant':
                \App\Models\Enseignant::create([
                    'user_id' => $user->id,
                    'matricule' => \App\Models\Enseignant::genererMatricule($nom),
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'genre' => 'm',
                    'date_naissance' => '1985-01-01',
                    'lieu_naissance' => 'Non spécifié',
                    'email' => $data['email'],
                    'telephone' => '',
                    'adresse' => 'Non spécifiée',
                    'specialite' => null,
                    'photo' => null,
                    'statut' => true,
                ]);
                break;

            case 'eleve':
                \App\Models\Eleve::create([
                    'user_id' => $user->id,
                    'matricule' => \App\Models\Eleve::genererMatricule($nom),
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'date_naissance' => '2015-01-01',
                    'lieu_naissance' => 'Non spécifié',
                    'genre' => 'm',
                    'adresse' => 'Non spécifiée',
                    'email' => $data['email'],
                    'telephone' => '',
                    'photo' => null,
                    'date_inscription' => now(),
                    'statut' => true,
                ]);
                break;

            case 'parent':
                \App\Models\ParentEleve::create([
                    'user_id' => $user->id,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'genre' => 'm',
                    'profession' => 'Non spécifié',
                    'email' => $data['email'],
                    'telephone' => '',
                    'adresse' => 'Non spécifiée',
                    'date_naissance' => '1985-01-01',
                    'lieu_naissance' => 'Non spécifié',
                    'photo' => null,
                    'notes' => null,
                    'statut' => true,
                ]);
                break;
        }

        return $user;
    }
}
