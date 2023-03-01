<?php

namespace App\Http\Livewire\Settings\Profile;

use App\Domains\Settings\ManageProfile\Services\UpdateProfileInformation;
use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditProfile extends Component
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';

    public function mount(SettingsIndexViewModel $view)
    {
        $this->firstName = $view->firstName ?? '';
        $this->lastName = $view->lastName ?? '';
        $this->email = $view->email ?? '';
    }

    public function render()
    {
        return view('settings.profile.livewire-profile');
    }

    public function save(): void
    {
        (new UpdateProfileInformation())->execute([
            'employee_id' => Auth::user()->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ]);
    }
}
