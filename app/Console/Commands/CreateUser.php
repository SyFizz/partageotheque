<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // The signature property contains the command name and its arguments.
    // The command name is make:user.
    // The command arguments are name, email, password, and role.
    // If the arguments are not provided, ask the user to provide them.
    // The role argument defaults to user.
    // The command signature is displayed when the command is run with the --help option.
    protected $signature = 'make:user
                            {name? : Le nom et prénom de l\'utilisateur.}
                            {email? : L\'adresse e-mail de l\'utilisateur.}
                            {password? : Le mot de passe de l\'utilisateur.}
                            {role=user : Le niveau de privilèges de l\'utilisateur.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet d\'enregistrer un nouveau compte utilisateur.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Get the arguments from the command signature.
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role = $this->argument('role');

        //If the arguments are not provided, ask the user to provide them.
        if (!$name) {
            $name = $this->ask('Déclinez l\'identité du nouvel utilisateur.');
        }
        if (!$email) {
            $email = $this->ask('Quelle est l\'adresse e-mail de l\'utilisateur ?');
        }
        if (!$password) {
            $password = $this->secret('Définissez le mot de passe de l\'utilisateur.');
        }
        if (!$role) {
            $role = $this->choice('Définissez le niveau de privilèges de l\'utilisateur.', ['admin', 'user'], 1);
        }

        //Validate the inputs with the following rules:
        //name: required, string, max:255
        //email: required, string, email, max:255, unique:users
        //password: required, string, min:8
        //role: required, string, in:admin,user

        try {
            Validator::make([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
            ], [
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'role' => ['required', 'string', 'in:admin,user'],
            ])->validate();
        } catch (ValidationException $e) {
            $this->error('Les données saisies sont invalides.');
            foreach ($e->errors() as $key => $value) {
                $this->warn($key . ': ' . $value[0]);
            }
            return;
        }
        $this->newLine('15');
        $this->info('Création de l\'utilisateur...');
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);
        $this->info('Utilisateur créé avec succès !');
        $this->info('Nom: ' . $user->name);
        $this->info('Email: ' . $user->email);
        $this->info('Mot de passe: ' . $password);
        $this->info('Rôle: ' . $user->role);

        $user->sendEmailVerificationNotification();
    }
}
