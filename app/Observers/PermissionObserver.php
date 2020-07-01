<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    public function creating(Permission $permission) {
        $permission->is_menu = request()->get('is_menu','0');
    }
}
