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
        $this->openModal = ! $this->openModal;

        if ($this->openModal) {
            $this->emit('focusNameField');
        }
    }

    public function store(): void
    {
        dd($this->permissions);
        $role = (new CreateRole())->execute([
            'employee_id' => Auth::user()->id,
            'name' => $this->name,
        ]);

        $this->notification()->success(
            $title = __('Changes saved'),
            $description = __('The role has been created.'),
        );

        $this->roles->push(SettingsRoleIndexViewHelper::role($role));
        $this->name = '';
        $this->toggle();
    }
}
