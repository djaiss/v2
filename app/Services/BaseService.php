<?php

namespace App\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    public Employee $author;

    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Get the permissions that users need to execute the service.
     */
    public function permissions(): string
    {
        return '';
    }

    /**
     * Validate an array against a set of rules.
     */
    public function validateRules(array $data): bool
    {
        Validator::make($data, $this->rules())->validate();

        if ($this->permissions() !== '') {
            $this->author = Employee::findOrFail($data['author_id']);

            if (! $this->author->hasTheRightTo($this->permissions())) {
                throw new NotEnoughPermissionException();
            }
        }

        return true;
    }

    public function valueOrNull($data, $index)
    {
        if (empty($data[$index])) {
            return;
        }

        return $data[$index] == '' ? null : $data[$index];
    }
}
