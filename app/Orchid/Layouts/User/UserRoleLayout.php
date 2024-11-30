<?php declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

class UserRoleLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Consultar los roles
        $rolesQuery = Role::query();

        // Si el usuario no es un Super Admin, excluir el rol "Super Admin"
        if (!$user->roles->contains('name', 'Super Admin')) {
            $rolesQuery->where('name', '!=', 'Super Admin');
        }

        return [
            Select::make('user.roles')  // Cambia aquí: el campo debe llamarse user.roles
                ->fromQuery($rolesQuery, 'name')  // Cambiado de fromModel a fromQuery
                ->multiple()
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to')
                ->required(),
        ];
    }
}