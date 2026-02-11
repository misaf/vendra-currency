<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Misaf\VendraCurrency\Models\Currency;
use Misaf\VendraUser\Models\User;

final class CurrencyPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->can('create-currency');
    }

    public function delete(User $user, Currency $currency): bool
    {
        return $user->can('delete-currency');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete-any-currency');
    }

    public function forceDelete(User $user, Currency $currency): bool
    {
        return $user->can('force-delete-currency');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force-delete-any-currency');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder-currency');
    }

    public function replicate(User $user, Currency $currency): bool
    {
        return $user->can('replicate-currency');
    }

    public function restore(User $user, Currency $currency): bool
    {
        return $user->can('restore-currency');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore-any-currency');
    }

    public function update(User $user, Currency $currency): bool
    {
        return $user->can('update-currency');
    }

    public function view(User $user, Currency $currency): bool
    {
        return $user->can('view-currency');
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view-any-currency');
    }
}
