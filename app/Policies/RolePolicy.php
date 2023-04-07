<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Store;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function before(Store $store, $ability)  // الستور اللي نوعة سوبر ادمن فقط لة كل صلاحيات جوة السيت
    {
        if($store->type == "super-admin"){

            return true;
        }
    }
    /**
     * Determine whether the Store can view any models.
     */
    public function viewAny(Store $store)
    {
        return $store->hasAbility('roles.view-any');
    }

    /**
     * Determine whether the Store can view the model.
     */
    public function view(Store $store, Role $role)
    {
        return $store->hasAbility('roles.view');
    }

    /**
     * Determine whether the Store can create models.
     */
    public function create(Store $store)
    {
        return $store->hasAbility('roles.create');
    }

    /**
     * Determine whether the Store can update the model.
     */
    public function update(Store $store, Role $role)
    {
        return $store->hasAbility('roles.update');
    }

    /**
     * Determine whether the Store can delete the model.
     */
    public function delete(Store $store, Role $role)
    {
        return $store->hasAbility('roles.delete');
    }

    /**
     * Determine whether the Store can restore the model.
     */
    public function restore(Store $store, Role $role)
    {
        //
    }

    /**
     * Determine whether the Store can permanently delete the model.
     */
    public function forceDelete(Store $store, Role $role)
    {
        //
    }
}
