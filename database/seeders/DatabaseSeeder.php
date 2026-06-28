<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::createAdmin('Admin', 'admin@admin.com', 'password');

        $user = User::query()->create([
            'name'     => 'Иван Петров',
            'email'    => 'user@example.com',
            'password' => 'password',
        ]);

        Post::query()->create([
            'user_id' => $user->id,
            'title'   => 'Первая публикация',
            'text'    => 'Текст первой публикации в блоге.',
        ]);

        Post::query()->create([
            'user_id' => $user->id,
            'title'   => 'Вторая публикация',
            'text'    => 'Ещё одна запись для проверки ленты.',
        ]);
    }
}
