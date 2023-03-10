<?php

namespace App\Http\Livewire\Settings\Roles;

use App\Domains\Settings\ManageRoles\Services\CreateRole;
use App\Domains\Settings\ManageRoles\Web\ViewHelpers\SettingsRoleIndexViewHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class ListAndCreateRole extends Component
{
    use Actions;

    public bool $openModal = false;
    public int $editedRoleId = 0;
    public Collection $roles;
    public Collection $permissions;
    public string $name;

    public function mount(array $view)
    {
        $this->openModal = false;
        $this->roles = $view['roles'];
        $this->permissions = $view['permissions'];
    }

    public function render()
    {
        return view('settings.roles.livewire-index');
    }

    public function toggle(): void
    {
        $this->name = '';
        $this->openModal = ! $this->openModal;

        if ($this->openModal) {
            $this->emit('focusNameField');
        }
    }

    public function toggleEdit(int $roleId = 0): void
    {
        $this->editedRoleId = $roleId;

        if ($roleId !== 0) {
            $role = $this->roles->filter(function (array $value, int $key) use ($roleId) {
                return $value['id'] === $roleId;
            })->first();

            $this->emit('focusNameField');
            $this->name = $role['name'];

        }
    }

    public function store(): void
    {
        $role = (new CreateRole())->execute([
            'employee_id' => Auth::user()->id,
            'name' => $this->name,
            'permissions' => $this->permissions->toArray(),
        ]);

        $this->notification()->success(
            $title = __('Element added'),
            $description = __('The role has been created.'),
        );

        $this->roles->push(SettingsRoleIndexViewHelper::role($role));
        $this->name = '';
        $this->toggle();
    }

    public function update(int $roleId): void
    {
        $role = (new UpdateRole())->execute([
            'employee_id' => Auth::user()->id,
            'role_id' => $roleId,
            'name' => $this->name,
            'permissions' => $this->permissions->toArray(),
        ]);

        $this->notification()->success(
            $title = __('Changes saved'),
            $description = __('The role has been updated.'),
        );

        $this->roles->push(SettingsRoleIndexViewHelper::role($role));
        $this->name = '';
        $this->toggle();
    }
}
