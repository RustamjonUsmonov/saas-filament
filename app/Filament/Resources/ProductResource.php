<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Details')
                    ->schema([
                        Forms\Components\Grid::make(2) // Two-column layout
                        ->schema([
                            Forms\Components\Select::make('vendor_id')
                                ->relationship('vendor', 'name')
                                ->required(),

                            Forms\Components\Select::make('product_category_id')
                                ->relationship('productCategory', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(), // Full width in grid
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(), // Full width outside grid
                    ]),

                Forms\Components\Section::make('Pricing & Stock')
                    ->schema([
                        Forms\Components\Grid::make(2) // Two-column layout
                        ->schema([
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('$'),

                            Forms\Components\TextInput::make('quantity')
                                ->minValue(0)
                                ->required()
                                ->numeric(),

                            Forms\Components\Radio::make('product_status_id')
                                ->label('Product Status')
                                ->options(fn() => \App\Models\ProductStatus::pluck('name', 'id'))
                                ->required()
                                ->columns(3) // Arrange in 3 columns for better spacing
                        ]),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productCategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productStatus.name')
                    ->badge()
                    ->color(fn($state, $record) => $record->productStatus->statusColor)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->emptyStateHeading('No Products Found')
            ->emptyStateDescription('Create your first product to get started.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Product'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->schema([
                                TextEntry::make('name')
                                    ->size(TextEntrySize::Large)
                                    ->weight('bold'),

                                TextEntry::make('price')
                                    ->money('USD')
                                    ->badge()
                                    ->color('success'),
                            ]),

                        TextEntry::make('description')
                            ->markdown()
                            ->columnSpanFull(),

                        Grid::make(['default' => 1, 'md' => 3])
                            ->schema([
                                TextEntry::make('quantity')
                                    ->label('Base Stock')
                                    ->badge()
                                    ->color(fn(int $state): string => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                                TextEntry::make('productCategory.name')
                                    ->label('Category'),

                                TextEntry::make('productStatus.name')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'Active' => 'success',
                                        'Draft' => 'gray',
                                        'Archived' => 'danger',
                                        default => 'warning',
                                    }),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Product Collections')
                    ->schema([
                        RepeatableEntry::make('productVariants')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make(['default' => 1, 'sm' => 4])
                                    ->schema([
                                        TextEntry::make('productAttribute.name')
                                            ->label('Style Attribute')
                                            ->badge()
                                            ->color('primary')
                                            ->icon('heroicon-o-tag'),
                                        TextEntry::make('value')
                                            ->label('Selection')
                                            ->weight('semibold')
                                            ->color('secondary')
                                            ->size('lg'),
                                        TextEntry::make('additional_price')
                                            ->label('Additional')
                                            ->prefix('+ $')
                                            ->color('success')
                                            ->icon('heroicon-o-currency-dollar')
                                            ->weight('bold'),
                                        TextEntry::make('quantity')
                                            ->label('Availability')
                                            ->badge()
                                            ->color(fn(int $state): string =>
                                            $state > 20 ? 'success' :
                                                ($state > 5 ? 'warning' : 'danger')
                                            )
                                            ->icon(fn(int $state): string =>
                                            $state > 20 ? 'heroicon-o-check-circle' :
                                                ($state > 5 ? 'heroicon-o-clock' : 'heroicon-o-exclamation-circle')
                                            )
                                            ->size('lg')
                                    ]),
                            ])
                            ->contained(true)
                            ->columns(1)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-slate-50 to-zinc-50 p-4 rounded-xl shadow-sm',
                            ]),
                    ])
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'border border-slate-200 rounded-2xl p-6',
                    ]),

                Section::make('Available Attributes')
                    ->schema([
                        RepeatableEntry::make('availableAttributes')
                            ->label('Attributes')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('name')
                                    ->badge()
                                    ->color('primary'),
                            ])
                            ->grid(3)
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->compact()
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
