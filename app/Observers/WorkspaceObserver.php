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
        if (empty($workspace->subdomain)) {
            $slug = Str::slug(Str::squish($workspace->name));

            // There can be duplicates still
            if (Workspace::query()->where('subdomain', $slug)->exists())
            {
                $randomString = Str::random(10);
                $slug = $slug . "-" . $randomString;
            }

            $workspace->subdomain = Str::lower($slug);
        }
    }
}
