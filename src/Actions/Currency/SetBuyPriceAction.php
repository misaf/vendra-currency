<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Actions\Currency;

use Exception;
use Misaf\VendraCurrency\Models\Currency;

final class SetBuyPriceAction
{
    public function execute(Currency $currency, int $price): bool
    {
        if (null !== $currency->sell_price && $price > $currency->sell_price) {
            throw new Exception('Buy price cannot be greater than sell price.');
        }

        $currency->update([
            'buy_price' => $price,
        ]);

        return $currency->wasChanged('buy_price');
    }
}
