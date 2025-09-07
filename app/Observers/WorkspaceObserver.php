<?php

namespace App\Observers;

use App\Models\Workspace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkspaceObserver
{
    /**
     * @param Workspace $workspace
     * @return void
     */
    public function creating(Workspace $workspace): void
    {
        if (empty($workspace->internal_domain)) {
            $slug = Str::slug(Str::squish($workspace->name));

            // There can be duplicates still
            if (Workspace::query()->where('internal_domain', $slug)->exists())
            {
                $randomString = Str::random(10);
                $slug = $slug . "-" . $randomString;
            }

            $workspace->internal_domain = Str::lower($slug);
        }
    }
}
