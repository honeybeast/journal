<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ModelRoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(HomeSeeder::class);
        $this->call(RoleEmailTypeSeeder::class);
        $this->call(EmailTemplateSeeder::class);
    }
}
