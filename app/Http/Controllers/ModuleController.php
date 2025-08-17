<?php

namespace App\Http\Controllers;

use App\Actions\Module\CreateModuleAction;
use App\Http\Requests\Module\StoreModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ModuleController extends Controller
{
    /**
     * Display the listing of the modules.
     *
     * @return Response
     */
    public function index(): Response
    {
        $modules = Module::query()
            ->select('id', 'title', DB::raw("substr(description, 1, 60) || '...' as description"), 'updated_at')
            ->paginate(15);

        return Inertia::render('Module/ModuleList', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new module.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Module/CreateModuleAction');
    }

    /**
     * Store a newly created module in storage.
     *
     * @param StoreModuleRequest $request
     * @param CreateModuleAction $action
     * @return RedirectResponse
     */
    public function store(StoreModuleRequest $request, CreateModuleAction $action): RedirectResponse
    {
        $module = $action->handle($request->validated());
        return redirect()->route('modules.show', $module);
    }

    /**
     * Display the specified module.
     *
     * @param Module $module
     * @return Response
     */
    public function show(Module $module): Response
    {
        return Inertia::render('Module/ShowModule', [
            'module' => $module
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, Module $module): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module): void
    {
        //
    }
}
