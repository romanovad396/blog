<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Layouts\Post\PostEditLayout;
use App\Orchid\Layouts\Post\PostListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'posts' => Post::query()
                ->with('user')
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Публикации блога';
    }

    public function description(): ?string
    {
        return 'Список всех публикаций в системе';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.posts',
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Создать')
                ->icon('bs.plus-circle')
                ->route('platform.systems.posts.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            PostListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Post::query()->findOrFail($request->get('id'))->delete();

        Toast::info('Публикация удалена');
    }
}
