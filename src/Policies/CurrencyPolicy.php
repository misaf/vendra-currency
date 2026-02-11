<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Misaf\VendraCurrency\Enums\CurrencyPolicyEnum;
use Misaf\VendraCurrency\Models\Currency;
use Misaf\VendraUser\Models\User;

final class CurrencyPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::CREATE);
    }

    public function delete(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::DELETE);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::DELETE_ANY);
    }

    public function forceDelete(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::FORCE_DELETE);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::FORCE_DELETE_ANY);
    }

    public function reorder(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::REORDER);
    }

    public function replicate(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::REPLICATE);
    }

    public function restore(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::RESTORE);
    }

    public function restoreAny(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::RESTORE_ANY);
    }

    public function update(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::UPDATE);
    }

    public function view(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPolicyEnum::VIEW);
    }

    public function viewAny(User $user): bool
    {
        return $user->can(CurrencyPolicyEnum::VIEW_ANY);
    }
}
