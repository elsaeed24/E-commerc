<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-any', Role::class);

        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.roles.create',[
            'role' =>new Role()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        Role::create($request->all());

        return redirect()
                ->route('roles.index')
                ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
       // $role_abilities = $role->abilities()->pluck('type', 'permission')->toArray();
       $this->authorize('update', $role);

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        $role->update($request->all);

        return redirect()
                ->route('roles.index')
                ->with('success', 'Role Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('delete', $role);

        $role->destroy($id);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
