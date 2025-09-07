<?php

namespace App\Http\Requests\Workspace;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkspaceRequest extends FormRequest
{
    /**
     * @param User $user
     * @param Workspace $workspace
     * @return bool
     */
    public function authorize(User $user, Workspace $workspace): bool
    {
        return $user->id === $workspace->user_id;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'labels' => ['array', 'min:0', 'max:5'],
            'labels.*' => ['string', 'min:3', 'max:255'],
            'subdomain' => ['required', 'string', 'min:3', 'max:255', 'unique:workspaces,subdomain'],
            'domain' => ['nullable', 'string', 'min:3', 'max:255', 'unique:workspaces,domain'],
            'path' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
