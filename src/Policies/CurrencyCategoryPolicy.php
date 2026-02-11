<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Misaf\VendraCurrency\Enums\CurrencyCategoryPolicyEnum;
use Misaf\VendraCurrency\Models\CurrencyCategory;
use Misaf\VendraUser\Models\User;

final class CurrencyCategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::CREATE);
    }

    public function delete(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::DELETE);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::DELETE_ANY);
    }

    public function forceDelete(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::FORCE_DELETE);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::FORCE_DELETE_ANY);
    }

    public function reorder(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::REORDER);
    }

    public function replicate(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::REPLICATE);
    }

    public function restore(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::RESTORE);
    }

    public function restoreAny(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::RESTORE_ANY);
    }

    public function update(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::UPDATE);
    }

    public function view(User $user, CurrencyCategory $currencyCategory): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::VIEW);
    }

    public function viewAny(User $user): bool
    {
        return $user->can(CurrencyCategoryPolicyEnum::VIEW_ANY);
    }
}
