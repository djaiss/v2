<?php

namespace App\Domains\Settings\ManageOffices\Services;

use App\Models\Employee;
use App\Models\Office;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class UpdateOffice extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'office_id' => 'required|integer|exists:offices,id',
            'name' => 'required|string|max:255',
        ];
    }

    public function permissions(): string
    {
        return Permission::COMPANY_MANAGE_OFFICES;
    }

    public function execute(array $data): Office
    {
        $this->validateRules($data);

        $office = Office::where('company_id', $this->author->company_id)
            ->findOrFail($data['office_id']);

        $office->name = $data['name'];
        $office->save();

        return $office;
    }
}
