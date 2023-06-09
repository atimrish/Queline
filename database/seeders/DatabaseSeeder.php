<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BanStatus;
use App\Models\Category;
use App\Models\GradeStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        GradeStatus::create([
            'name' => 'like'
        ]);

        GradeStatus::create([
            'name' => 'dislike'
        ]);

        BanStatus::create([
            'name' => 'Нет ограничений'
        ]);

        BanStatus::create([
            'name' => 'Нарушение'
        ]);

        BanStatus::create([
            'name' => 'Теневой бан'
        ]);

        BanStatus::create([
            'name' => 'Бан'
        ]);

        Role::create([
            'name' => 'Администратор'
        ]);

        Role::create([
            'name' => 'Пользователь'
        ]);

//        Category::factory(10)->create();

        User::create([
            'nickname' => 'admin',
            'email' => 'admin@test.ru',
            'password' => Hash::make('admin123'),
            'description' => 'admin account',
            'role_id' => 1
        ]);
    }
}
