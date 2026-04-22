<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Control panel access — admins and users with explicit role.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Na etapie rozwoju: pusta baza ról → każdy uwierzytelniony user ma dostęp.
        // Produkcyjnie: wymagana rola "admin" lub "crm_user".
        if ($this->roles()->count() === 0) {
            return true;
        }

        return $this->hasAnyRole(['admin', 'super_admin', 'crm_user']);
    }
}
