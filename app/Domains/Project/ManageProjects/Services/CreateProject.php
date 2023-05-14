<?php

namespace App\Domains\Project\ManageProjects\Services;

use App\Exceptions\ProjectCodeAlreadyExistException;
use App\Jobs\LogAccountAudit;
use App\Models\Organization\Project;
use App\Models\Organization\ProjectMemberActivity;
use App\Models\Organization\User;
use App\Services\BaseService;
use Carbon\Carbon;

class CreateProject extends BaseService
{
    protected array $data;

    protected Project $project;

    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'organization_id' => 'required|integer|exists:organizations,id',
            'author_id' => 'required|integer|exists:users,id',
            'project_lead_id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'short_code' => 'nullable|string|max:3',
            'summary' => 'nullable|string|max:255',
            'emoji' => 'nullable|string|max:5',
            'description' => 'nullable|string|max:65535',
        ];
    }

    /**
     * Create a project.
     */
    public function execute(array $data): Project
    {
        $this->data = $data;
        $this->validate();
        $this->createProject();
        $this->logActivity();
        $this->log();

        return $this->project;
    }

    private function validate(): void
    {
        $this->validateRules($this->data);

        $this->author($this->data['author_id'])
            ->inCompany($this->data['organization_id'])
            ->asNormalUser()
            ->canExecuteService();

        // make sure the project code, if provided, is unique in the company
        if (! is_null($this->valueOrNull($this->data, 'code'))) {
            $count = Project::where('organization_id', $this->data['organization_id'])
                ->where('code', $this->data['code'])
                ->count();

            if ($count > 0) {
                throw new ProjectCodeAlreadyExistException();
            }
        }

        // make sure the project short code, if provided, is unique in the company
        if (! is_null($this->valueOrNull($this->data, 'short_code'))) {
            $count = Project::where('organization_id', $this->data['organization_id'])
                ->where('short_code', $this->data['short_code'])
                ->count();

            if ($count > 0) {
                throw new ProjectCodeAlreadyExistException();
            }
        }

        if (! is_null($this->valueOrNull($this->data, 'project_lead_id'))) {
            User::where('organization_id', $this->data['organization_id'])
                ->findOrFail($this->data['project_lead_id']);
        }
    }

    private function createProject(): void
    {
        $this->project = Project::create([
            'organization_id' => $this->data['organization_id'],
            'project_lead_id' => $this->valueOrNull($this->data, 'project_lead_id'),
            'name' => $this->data['name'],
            'summary' => $this->valueOrNull($this->data, 'summary'),
            'status' => Project::CREATED,
            'code' => $this->valueOrNull($this->data, 'code'),
            'short_code' => $this->valueOrNull($this->data, 'short_code'),
            'emoji' => $this->valueOrNull($this->data, 'emoji'),
            'description' => $this->valueOrNull($this->data, 'description'),
        ]);

        if (! is_null($this->valueOrNull($this->data, 'project_lead_id'))) {
            $this->project->users()->syncWithoutDetaching([
                $this->data['project_lead_id'] => [
                    'role' => trans('project.project_title_lead'),
                ],
            ]);
        }
    }

    private function logActivity(): void
    {
        ProjectMemberActivity::create([
            'project_id' => $this->project->id,
            'user_id' => $this->author->id,
        ]);
    }

    private function log(): void
    {
        LogAccountAudit::dispatch([
            'organization_id' => $this->data['organization_id'],
            'action' => 'project_created',
            'author_id' => $this->author->id,
            'author_name' => $this->author->name,
            'audited_at' => Carbon::now(),
            'objects' => json_encode([
                'project_id' => $this->project->id,
                'project_name' => $this->project->name,
            ]),
        ])->onQueue('low');
    }
}
