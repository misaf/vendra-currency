<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Filament\Clusters\Resources\CurrencyCategories\Tables;

use Awcodes\BadgeableColumn\Components\Badge;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Misaf\VendraCurrency\Models\CurrencyCategory;

final class CurrencyCategoryTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row')
                    ->label('#')
                    ->rowIndex(),

                // SpatieMediaLibraryImageColumn::make('image')
                //     ->circular()
                //     ->conversion('thumb-table')
                //     ->defaultImageUrl(url('coin-payment/images/default.png'))
                //     ->extraImgAttributes(['class' => 'saturate-50', 'loading' => 'lazy'])
                //     ->label(__('vendra-currency::attributes.image'))
                //     ->stacked(),

                BadgeableColumn::make('name')
                    ->alignStart()
                    ->description(fn(CurrencyCategory $record): string => $record->description)
                    ->icon('heroicon-m-folder-plus')
                    ->label(__('vendra-currency::attributes.name'))
                    ->searchable()
                    ->suffixBadges([
                        Badge::make('count')
                            ->label(fn(CurrencyCategory $record): string => (string) Number::format($record->currencies()->count()))
                            ->size(Size::Small),
                    ]),

                TextColumn::make('slug')
                    ->alignStart()
                    ->label(__('vendra-currency::attributes.slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('status')
                    ->label(__('vendra-currency::attributes.status'))
                    ->onIcon('heroicon-m-bolt'),

                TextColumn::make('created_at')
                    ->alignCenter()
                    ->badge()
                    ->extraCellAttributes(['dir' => 'ltr'])
                    ->label(__('vendra-currency::attributes.created_at'))
                    ->sinceTooltip()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->unless(
                        app()->isLocale('fa'),
                        fn(TextColumn $column) => $column->jalaliDateTime('Y-m-d H:i', toLatin: true),
                        fn(TextColumn $column) => $column->dateTime('Y-m-d H:i')
                    ),

                TextColumn::make('updated_at')
                    ->alignCenter()
                    ->badge()
                    ->extraCellAttributes(['dir' => 'ltr'])
                    ->label(__('vendra-currency::attributes.updated_at'))
                    ->sinceTooltip()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->unless(
                        app()->isLocale('fa'),
                        fn(TextColumn $column) => $column->jalaliDateTime('Y-m-d H:i', toLatin: true),
                        fn(TextColumn $column) => $column->dateTime('Y-m-d H:i')
                    ),
            ])
            ->filters(
                [
                    QueryBuilder::make()
                        ->constraints([
                            TextConstraint::make('name')
                                ->label(__('vendra-currency::attributes.name')),

                            TextConstraint::make('slug')
                                ->label(__('vendra-currency::attributes.slug')),

                            BooleanConstraint::make('status')
                                ->label(__('vendra-currency::attributes.status')),
                        ]),
                ],
                layout: FiltersLayout::AboveContentCollapsible,
            )
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),

                    EditAction::make(),

                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort(column: 'position', direction: 'desc')
            ->reorderable(column: 'position', direction: 'desc');
    }
}
