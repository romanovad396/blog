<?php

declare(strict_types=1);

use App\Orchid\Screens\Post\PostEditScreen;
use App\Orchid\Screens\Post\PostListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Posts
Route::screen('posts/{post}/edit', PostEditScreen::class)
    ->name('platform.systems.posts.edit')
    ->breadcrumbs(fn (Trail $trail, $post) => $trail
        ->parent('platform.systems.posts')
        ->push($post->title, route('platform.systems.posts.edit', $post)));

Route::screen('posts/create', PostEditScreen::class)
    ->name('platform.systems.posts.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.posts')
        ->push(__('Create'), route('platform.systems.posts.create')));

Route::screen('posts', PostListScreen::class)
    ->name('platform.systems.posts')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Публикации', route('platform.systems.posts')));
