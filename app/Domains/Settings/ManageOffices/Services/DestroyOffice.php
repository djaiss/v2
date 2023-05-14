<?php

namespace App\Domains\Settings\ManageOffices\Services;

use App\Models\Office;
use App\Models\Permission;
use App\Services\BaseService;

class DestroyOffice extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:users,id',
            'office_id' => 'required|integer|exists:offices,id',
        ];
    }

    public function permissions(): string
    {
        return Permission::ORGANIZATION_MANAGE_OFFICES;
    }

    public function execute(array $data): void
    {
        $this->validateRules($data);

        $office = Office::where('organization_id', $this->author->organization_id)
            ->findOrFail($data['office_id']);

        $office->delete();
    }
}
