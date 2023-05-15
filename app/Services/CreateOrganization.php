<?php

namespace App\Services;

use App\Jobs\SetupOrganization;
use App\Models\Member;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class CreateOrganization extends BaseService
{
    private User $user;

    private string $slug;

    private array $data;

    private Member $member;

    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'is_public' => 'required|boolean',
        ];
    }

    /**
     * Create an organization and associate the user to it, as the owner.
     */
    public function execute(array $data): Organization
    {
        $this->validateRules($data);
        $this->data = $data;

        $this->checkUser();
        $this->checkSlugUniqueness();
        $this->createOrganization();
        $this->addMember();

        SetupOrganization::dispatch($this->organization, $this->member);

        return $this->organization;
    }

    private function checkUser(): void
    {
        $this->user = User::findOrFail($this->data['user_id']);

        if ($this->user->organization_id) {
            throw new Exception('User already has an organization');
        }
    }

    private function checkSlugUniqueness(): void
    {
        $this->slug = Str::slug($this->data['name']);

        if (Organization::where('slug', $this->slug)->exists()) {
            throw new Exception(trans_key('This name already exists'));
        }

        if (User::where('slug', $this->slug)->exists()) {
            throw new Exception(trans_key('This name already exists'));
        }
    }

    private function createOrganization(): void
    {
        $this->organization = Organization::create([
            'name' => $this->data['name'],
            'slug' => $this->slug,
            'invitation_code' => Str::random(40),
            'is_public' => $this->data['is_public'],
        ]);
    }

    private function addMember(): void
    {
        $this->member = Member::create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
        ]);
    }
}
