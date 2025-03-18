<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\ProductVariantResource\Pages;
use App\Filament\Resources\ProductVariantResource\RelationManagers;
use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'phosphor-tag';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Variation Details')
                    ->description('Configure the product variation attributes and pricing')
                    ->schema([
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 3,
                        ])->schema([
                            Forms\Components\Select::make('product_id')
                                ->relationship('product', 'name')
                                ->label('Product')
                                ->required()
                                ->columnSpan([
                                    'default' => 1,
                                    'md' => 1,
                                ]),

                            Forms\Components\Select::make('product_attribute_id')
                                ->relationship('productAttribute', 'name')
                                ->label('Attribute')
                                ->required()
                                ->columnSpan([
                                    'default' => 1,
                                    'md' => 1,
                                ]),

                            Forms\Components\TextInput::make('value')
                                ->label('Attribute Value')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan([
                                    'default' => 1,
                                    'md' => 2,
                                    'lg' => 1,
                                ]),
                        ]),

                        Forms\Components\Section::make('Inventory & Pricing')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('additional_price')
                                        ->label('Additional Price')
                                        ->prefix('$')
                                        ->numeric()
                                        ->required(),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Stock Quantity')
                                        ->numeric()
                                        ->required(),
                                ]),
                            ])
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('productAttribute.name')
                    ->label('Attribute')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Value copied to clipboard'),

                Tables\Columns\TextColumn::make('additional_price')
                    ->label('Extra Price')
                    ->money('USD')
                    ->sortable()
                    ->alignEnd()
                    ->color('success'),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn(int $state): string => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->icon(fn(int $state): string => $state > 10 ? 'heroicon-m-check-circle' : ($state > 0 ? 'heroicon-m-exclamation-circle' : 'heroicon-m-x-circle')),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->searchable()
            ->paginated([10, 25, 50, 100])
            ->poll('60s')
            ->filters([
                // Keeping your existing filters
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->emptyStateHeading('No Product Variations Found')
            ->emptyStateDescription('Create your first product variation to get started.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Variation'),
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
            'index' => \App\Filament\Admin\Resources\ProductVariantResource\Pages\ListProductVariants::route('/'),
            'create' => \App\Filament\Admin\Resources\ProductVariantResource\Pages\CreateProductVariant::route('/create'),
            'edit' => \App\Filament\Admin\Resources\ProductVariantResource\Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
