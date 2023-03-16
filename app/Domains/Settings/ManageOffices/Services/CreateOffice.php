<?php

namespace App\Domains\Settings\ManageOffices\Services;

use App\Models\Office;
use App\Models\Permission;
use App\Services\BaseService;

class CreateOffice extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
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

        $office = Office::create([
            'company_id' => $this->author->company_id,
            'name' => $data['name'],
        ]);

        return $office;
    }
}
