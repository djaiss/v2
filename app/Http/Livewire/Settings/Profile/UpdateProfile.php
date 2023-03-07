<?php

namespace App\Http\Livewire\Settings\Profile;

use App\Domains\Settings\ManageProfile\Services\UpdateProfileInformation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class UpdateProfile extends Component
{
    use Actions;

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public function mount(array $view)
    {
        $this->firstName = $view['firstName'] ?? '';
        $this->lastName = $view['lastName'] ?? '';
        $this->email = $view['email'] ?? '';
    }

    public function render()
    {
        return view('settings.profile.livewire-update-profile');
    }

    public function store(): void
    {
        (new UpdateProfileInformation())->execute([
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
