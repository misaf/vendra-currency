<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Misaf\VendraTenant\Traits\BelongsToTenant;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int $tenant_id
 * @property int $currency_category_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $iso_code
 * @property float $conversion_rate
 * @property int $decimal_place
 * @property int $buy_price
 * @property int $sell_price
 * @property bool $is_default
 * @property int $position
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
final class Currency extends Model implements HasMedia, Sortable
{
    use BelongsToTenant;

    /** @use HasFactory<Currency> */
    use HasFactory;

    use InteractsWithMedia;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;

    protected $casts = [
        'id'                   => 'integer',
        'tenant_id'            => 'integer',
        'currency_category_id' => 'integer',
        'name'                 => 'string',
        'description'          => 'string',
        'slug'                 => 'string',
        'iso_code'             => 'string',
        'conversion_rate'      => 'float',
        'decimal_place'        => 'integer',
        'buy_price'            => 'integer',
        'sell_price'           => 'integer',
        'is_default'           => 'boolean',
        'position'             => 'integer',
        'status'               => 'boolean',
    ];

    protected $fillable = [
        'currency_category_id',
        'name',
        'description',
        'slug',
        'iso_code',
        'conversion_rate',
        'decimal_place',
        'buy_price',
        'sell_price',
        'is_default',
        'position',
        'status',
    ];

    protected $hidden = [
        'tenant_id',
    ];

    /**
     * @return BelongsTo<CurrencyCategory, $this>
     */
    public function currencyCategory(): BelongsTo
    {
        return $this->belongsTo(CurrencyCategory::class);
    }

    /**
     * @return MorphMany<Media, $this>
     */
    public function multimedia(): MorphMany
    {
        return $this->media();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('thumb-table')
            ->width(48)
            ->format('webp');

        $this->addMediaConversion('small')
            ->width(300)
            ->format('webp');

        $this->addMediaConversion('medium')
            ->width(500)
            ->format('webp');

        $this->addMediaConversion('large')
            ->width(800)
            ->format('webp');

        $this->addMediaConversion('extra-large')
            ->width(1200)
            ->format('webp');
    }

    public function registerMediaConversions(?Media $media = null): void {}

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logExcept(['id']);
    }
}
