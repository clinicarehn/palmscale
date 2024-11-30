<?php declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Orchid\Layouts\Role\RoleListLayout;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;

class RoleListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $query = Role::filters()->defaultSort('id', 'desc');

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario tiene el rol 'Super Admin'
        $isSuperAdmin = $user->roles->contains('name', 'Super Admin');

        // Excluir el rol "Super Admin" si el usuario no es un Super Admin
        if (!$isSuperAdmin) {
            $query->where('name', '!=', 'Super Admin');
        }

        return [
            'roles' => $query->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Role Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all roles, including their permissions and associated users.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->href(route('platform.systems.roles.create')),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            RoleListLayout::class,
        ];
    }
}
