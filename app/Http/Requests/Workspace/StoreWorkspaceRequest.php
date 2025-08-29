<?php

namespace App\Http\Requests\Workspace;

use App\Models\Workspace;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreWorkspaceRequest extends FormRequest
{
    /**
     * @return Response
     */
    public function authorize(): Response
    {
        return Gate::authorize('create', Workspace::class);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255']
        ];
    }
}
