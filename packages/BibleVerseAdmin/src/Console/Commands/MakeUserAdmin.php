<?php

namespace Starprog\BibleVerseAdmin\Console\Commands;

use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userModel = config('bible-verse-admin.models.user');
        $email = $this->argument('email');
        
        $user = $userModel::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->is_admin) {
            $this->info("User '{$user->name}' ({$email}) is already an admin.");
            return 0;
        }
        
        $user->is_admin = true;
        $user->save();
        
        $this->info("✓ User '{$user->name}' ({$email}) is now an admin!");
        $this->info("They can access the admin panel at: /" . config('bible-verse-admin.route_prefix') . "/dashboard");
        
        return 0;
    }
}
