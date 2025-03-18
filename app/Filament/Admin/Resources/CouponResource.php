<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'phosphor-ticket';

    protected static ?string $navigationGroup = 'Payment Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->icon('phosphor-sparkle')
                    ->iconColor('primary')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label('Coupon Code')
                                    ->required()
                                    ->unique()
                                    ->maxLength(255)
                                    ->placeholder('Enter unique coupon code')
                                    ->helperText('Make sure it is unique to avoid conflicts.'),

                                Forms\Components\TextInput::make('usage_limit')
                                    ->label('Usage Limit')
                                    ->numeric()
                                    ->placeholder('Enter max usage count (optional)'),

                                Forms\Components\TextInput::make('discount')
                                    ->label('Discount Amount')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->placeholder('Enter discount value')
                                    ->helperText('Use numbers only. The type will determine if it’s a percentage or fixed amount.'),

                                Forms\Components\Select::make('type')
                                    ->label('Discount Type')
                                    ->required()
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->default('percentage')
                                    ->native(false) // Enables a searchable dropdown
                                    ->placeholder('Select discount type'),
                            ]),
                    ]),

                Forms\Components\Section::make('Validity Period')
                    ->icon('phosphor-hourglass-high')
                    ->iconColor('primary')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('valid_from')
                                    ->label('Valid From')
                                    ->required()
                                    ->placeholder('Select start date')
                                    ->hint('The coupon will be active from this date.')
                                    ->reactive() // Ensures real-time validation
                                    ->afterStateUpdated(fn($state, callable $set) => $set('valid_to', max($state, old('valid_to'))) // Ensures valid_to is not before valid_from
                                    ),

                                Forms\Components\DateTimePicker::make('valid_to')
                                    ->label('Valid To')
                                    ->required()
                                    ->placeholder('Select end date')
                                    ->hint('The coupon will expire after this date.')
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $set, callable $get) => $set('valid_from', min($state, $get('valid_from'))) // Ensures valid_from is before valid_to
                                    )
                                    ->after('valid_from'), // Ensures valid_to is after valid_from
                            ]),
                    ])

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Coupon Code')
                    ->searchable()
                    ->sortable()
                    ->tooltip('Unique coupon identifier'),

                Tables\Columns\TextColumn::make('discount')
                    ->label('Discount Amount')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => $record->type === 'percentage' ? 'success' : 'primary')
                    ->tooltip('Discount applied to the order'),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valid From')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->tooltip('Start date of coupon validity'),

                Tables\Columns\TextColumn::make('valid_to')
                    ->label('Valid To')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->tooltip('End date of coupon validity'),

                Tables\Columns\TextColumn::make('usage_limit')
                    ->label('Usage Limit')
                    ->numeric()
                    ->sortable()
                    ->tooltip('Maximum number of times this coupon can be used'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn($state) => $state === 'percentage' ? 'success' : 'warning')
                    ->tooltip('Discount type: Fixed or Percentage'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip('Date when the coupon was created'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip('Last updated time of the coupon'),
            ])
            ->filters([
                // You can add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit this coupon'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->tooltip('Delete selected coupons'),
                ]),
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
            'index' => \App\Filament\Admin\Resources\CouponResource\Pages\ListCoupons::route('/'),
            'create' => \App\Filament\Admin\Resources\CouponResource\Pages\CreateCoupon::route('/create'),
            'edit' => \App\Filament\Admin\Resources\CouponResource\Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
