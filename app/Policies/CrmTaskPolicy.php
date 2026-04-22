<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CrmTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmTaskPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CrmTask');
    }

    public function view(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('View:CrmTask');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CrmTask');
    }

    public function update(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('Update:CrmTask');
    }

    public function delete(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('Delete:CrmTask');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CrmTask');
    }

    public function restore(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('Restore:CrmTask');
    }

    public function forceDelete(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('ForceDelete:CrmTask');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CrmTask');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CrmTask');
    }

    public function replicate(AuthUser $authUser, CrmTask $crmTask): bool
    {
        return $authUser->can('Replicate:CrmTask');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CrmTask');
    }

}