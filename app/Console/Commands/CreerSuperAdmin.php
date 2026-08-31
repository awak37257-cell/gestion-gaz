<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreerSuperAdmin extends Command
{
    protected $signature = 'superadmin:creer';

    protected $description = "Crée le compte super-admin (l'éditeur du logiciel), sans client rattaché";

    public function handle(): int
    {
        $nom = $this->ask('Nom');
        $email = $this->ask('Email');
        $motDePasse = $this->ask('Mot de passe (8 caractères minimum) — visible à la saisie');

        $validateur = Validator::make(
            ['nom' => $nom, 'email' => $email, 'mot_de_passe' => $motDePasse],
            [
                'nom' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'mot_de_passe' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validateur->fails()) {
            foreach ($validateur->errors()->all() as $erreur) {
                $this->error($erreur);
            }

            return self::FAILURE;
        }

        User::create([
            'client_id' => null,
            'name' => $nom,
            'email' => $email,
            'password' => $motDePasse,
        ]);

        $this->info("Super-admin créé : {$email}");

        return self::SUCCESS;
    }
}