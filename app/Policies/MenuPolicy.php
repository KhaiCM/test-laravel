<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\HasPermission;

class MenuPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function view(User $user, Menu $menu)
    {
//        return $user->hasPermission('view_menu');
        dd(444);
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // dd(222222222222);
        return $user->hasPermission('create_menu');
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function update(User $user, Menu $menu)
    {
        dd(9999);
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function delete(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can restore the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function restore(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function forceDelete(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function show(User $user, Menu $menu)
    {
//        return false;
    }
}
