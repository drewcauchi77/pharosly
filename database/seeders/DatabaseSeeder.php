<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\User;
use App\Models\Workspace;
use Database\Factories\WorkspaceFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        foreach ($users as $user)
        {
            $workspace = Workspace::factory()->for($user)->create();

            Episode::factory()
                ->count(70)
                ->for($workspace)
                ->create();
        }
    }
}
