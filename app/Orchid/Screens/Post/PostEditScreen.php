<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Layouts\Post\PostEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    public $post;

    public function query(Post $post): iterable
    {
        $post->load('user');

        return [
            'post' => $post,
        ];
    }

    public function name(): ?string
    {
        return $this->post->exists ? 'Редактировать публикацию' : 'Создать публикацию';
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
            Button::make('Удалить')
                ->icon('bs.trash3')
                ->confirm('Удалить эту публикацию?')
                ->method('remove')
                ->canSee($this->post->exists),

            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(PostEditLayout::class)
                ->title('Данные публикации')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    public function save(Post $post, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'post.user_id' => ['required', 'exists:users,id'],
            'post.title'   => ['required', 'string', 'max:255'],
            'post.text'    => ['required', 'string'],
        ]);

        $post->fill($data['post'])->save();

        Toast::info('Публикация сохранена');

        return redirect()->route('platform.systems.posts');
    }

    public function remove(Post $post): RedirectResponse
    {
        $post->delete();

        Toast::info('Публикация удалена');

        return redirect()->route('platform.systems.posts');
    }
}
