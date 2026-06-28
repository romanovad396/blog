<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Post;

use App\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PostEditLayout extends Rows
{
    protected function fields(): array
    {
        return [
            Relation::make('post.user_id')
                ->fromModel(User::class, 'name')
                ->title('Автор')
                ->required(),

            Input::make('post.title')
                ->title('Заголовок')
                ->placeholder('Название публикации')
                ->required(),

            TextArea::make('post.text')
                ->title('Текст')
                ->rows(10)
                ->required(),
        ];
    }
}
