<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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
        return $store->hasAbility('categories.view-any');
    }

    /**
     * Determine whether the Store can view the model.
     */
    public function view(Store $store, Category $category)
    {
        return $store->hasAbility('categories.view');
    }

    /**
     * Determine whether the Store can create models.
     */
    public function create(Store $store)
    {
        return $store->hasAbility('categories.create');
    }

    /**
     * Determine whether the Store can update the model.
     */
    public function update(Store $store, Category $category)
    {
        return $store->hasAbility('categories.update');
    }

    /**
     * Determine whether the Store can delete the model.
     */
    public function delete(Store $store, Category $category)
    {
        return $store->hasAbility('categories.delete');
    }

    /**
     * Determine whether the Store can restore the model.
     */
    public function restore(Store $store, Category $category)
    {
        //
    }

    /**
     * Determine whether the Store can permanently delete the model.
     */
    public function forceDelete(Store $store, Category $category)
    {
        //
    }
}
