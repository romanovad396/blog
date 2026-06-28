<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text'  => ['required', 'string'],
        ]);

        $post = $request->user()->posts()->create($data);

        return response()->json([
            'post' => $this->serializePost($post),
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'limit'  => ['nullable', 'integer', 'min:1', 'max:100'],
            'offset' => ['nullable', 'integer', 'min:0'],
            'sort'   => ['nullable', 'in:date,title'],
        ]);

        $query = Post::query()->with('user:id,name,email');

        $this->applySorting($query, $request->input('sort', 'date'));

        $limit = (int) $request->input('limit', 10);
        $offset = (int) $request->input('offset', 0);

        $posts = $query
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(fn (Post $post) => $this->serializePost($post));

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function myPosts(Request $request): JsonResponse
    {
        $request->validate([
            'limit'  => ['nullable', 'integer', 'min:1', 'max:100'],
            'offset' => ['nullable', 'integer', 'min:0'],
            'sort'   => ['nullable', 'in:date,title'],
        ]);

        $query = $request->user()->posts()->newQuery();

        $this->applySorting($query, $request->input('sort', 'date'));

        $limit = (int) $request->input('limit', 10);
        $offset = (int) $request->input('offset', 0);

        $posts = $query
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(fn (Post $post) => $this->serializePost($post));

        return response()->json([
            'posts' => $posts,
        ]);
    }

    private function applySorting($query, string $sort): void
    {
        if ($sort === 'title') {
            $query->orderBy('title');
        } else {
            $query->orderByDesc('created_at');
        }
    }

    private function serializePost(Post $post): array
    {
        return [
            'id'         => $post->id,
            'title'      => $post->title,
            'text'       => $post->text,
            'user_id'    => $post->user_id,
            'author'     => $post->relationLoaded('user') ? [
                'id'    => $post->user->id,
                'name'  => $post->user->name,
                'email' => $post->user->email,
            ] : null,
            'created_at' => $post->created_at?->toIso8601String(),
            'updated_at' => $post->updated_at?->toIso8601String(),
        ];
    }
}
