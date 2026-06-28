<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    protected $target = 'posts';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->render(fn (Post $post) => Link::make((string) $post->id)
                    ->route('platform.systems.posts.edit', $post)),

            TD::make('title', 'Заголовок')
                ->sort()
                ->render(fn (Post $post) => Link::make($post->title)
                    ->route('platform.systems.posts.edit', $post)),

            TD::make('user.name', 'Автор')
                ->render(fn (Post $post) => $post->user?->name ?? '—'),

            TD::make('created_at', 'Дата')
                ->sort()
                ->render(fn (Post $post) => $post->created_at?->format('d.m.Y H:i')),
        ];
    }
}
