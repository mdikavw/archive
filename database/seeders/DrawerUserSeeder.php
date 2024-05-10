<?php

namespace Database\Seeders;

use App\Models\Drawer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrawerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(50)->create();
        $drawers = Drawer::factory(10)->create();

        foreach ($drawers as $drawer)
        {
            $usersInDrawer = $users->random(rand(1, 5));
            foreach ($usersInDrawer as $user)
            {
                DB::table('draweruser')->insert([
                    'drawer_id' => $drawer->id,
                    'user_id' => $user->id,
                    'is_moderator' => rand(true, false),
                ]);
            }
        }
    }
}
