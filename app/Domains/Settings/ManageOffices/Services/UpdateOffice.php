<?php

namespace App\Domains\Settings\ManageOffices\Services;

use App\Models\Office;
use App\Models\Permission;
use App\Services\BaseService;

class UpdateOffice extends BaseService
{
    private Office $office;

    private array $data;

    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'office_id' => 'required|integer|exists:offices,id',
            'name' => 'required|string|max:255',
            'is_main_office' => 'required|boolean',
        ];
    }

    public function permissions(): string
    {
        return Permission::COMPANY_MANAGE_OFFICES;
    }

    public function execute(array $data): Office
    {
        $this->validateRules($data);
        $this->data = $data;

        $this->office = Office::where('company_id', $this->author->company_id)
            ->findOrFail($data['office_id']);

        $this->edit();
        $this->toggleMainOfficeForAllTheOtherOffices();

        return $this->office;
    }

    private function edit(): void
    {
        $this->office->name = $this->data['name'];
        $this->office->is_main_office = $this->data['is_main_office'];
        $this->office->save();
    }

    private function toggleMainOfficeForAllTheOtherOffices(): void
    {
        if ($this->data['is_main_office']) {
            Office::where('company_id', $this->author->company_id)
                ->whereNot('id', $this->office->id)
                ->update([
                    'is_main_office' => false,
                ]);
        }
    }
}
