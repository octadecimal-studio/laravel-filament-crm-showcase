<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CrmNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrmNotePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CrmNote');
    }

    public function view(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('View:CrmNote');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CrmNote');
    }

    public function update(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('Update:CrmNote');
    }

    public function delete(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('Delete:CrmNote');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CrmNote');
    }

    public function restore(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('Restore:CrmNote');
    }

    public function forceDelete(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('ForceDelete:CrmNote');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CrmNote');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CrmNote');
    }

    public function replicate(AuthUser $authUser, CrmNote $crmNote): bool
    {
        return $authUser->can('Replicate:CrmNote');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CrmNote');
    }

}