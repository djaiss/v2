<?php

namespace App\Http\Livewire\Settings\Roles;

use App\Domains\Settings\ManageRoles\Services\CreateRole;
use App\Domains\Settings\ManageRoles\Web\ViewModels\SettingsRoleIndexViewModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class ListAndCreateRole extends Component
{
    use Actions;

    public bool $openModal = false;

    public Collection $roles;

    public function mount(SettingsRoleIndexViewModel $view)
    {
        $this->openModal = false;
        $this->roles = $view->roles;
    }

    public function render()
    {
        return view('settings.roles.livewire-index');
    }

    public function toggle(): void
    {
        $this->openModal = ! $this->openModal;
    }

    public function store(): void
    {
        (new CreateRole())->execute([
            'employee_id' => Auth::user()->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ]);

        $this->notification()->success(
            $title = __('Changes saved'),
            $description = __('Your profile was successfully saved.'),
        );
    }
}
