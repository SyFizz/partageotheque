<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command promotes a user to admin status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Quelle est l\'adresse e-mail de l\'utilisateur à promouvoir ?');
        $user = \App\Models\User::where('email', $email)->first();
        if ($user) {
            $user->role = 'admin';
            $user->save();
            $this->info("User $email is now an admin.");
        } else {
            $this->error("User $email not found.");
        }
    }
}
