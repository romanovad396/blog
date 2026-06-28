<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;

class RoleFilter extends Filter
{
    /**
     * Отображаемое имя фильтра.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Roles');
    }

    /**
     * Массив сопоставленных параметров.
     *
     * @return array
     */
    public function parameters(): array
    {
        return ['role'];
    }

    /**
     * Применить к заданному построителю запросов Eloquent.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereHas('roles', function (Builder $query) {
            $query->where('slug', $this->request->get('role'));
        });
    }

    /**
     * Получите поля для отображения.
     */
    public function display(): array
    {
        return [
            Select::make('role')
                ->fromModel(Role::class, 'name', 'slug')
                ->empty()
                ->value($this->request->get('role'))
                ->title(__('Roles')),
        ];
    }

    /**
     * Значение для отображения.
     */
    public function value(): string
    {
        return $this->name().': '.Role::where('slug', $this->request->get('role'))->first()->name;
    }
}
