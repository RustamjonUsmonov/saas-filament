<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\OrderResource\Pages;
use App\Filament\User\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'phosphor-shipping-container';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('status_id')
                    ->relationship('status', 'name'),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
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
                                TextEntry::make('user.name')
                                    ->size(TextEntrySize::Large)
                                    ->weight('bold'),

                                TextEntry::make('total_amount')
                                    ->money('USD')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('status.name')
                                    ->badge()
                                    ->color('primary'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Order items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make(['default' => 1, 'sm' => 4])
                                    ->schema([
                                        TextEntry::make('price')
                                            ->label('Price')
                                            ->prefix('$')
                                            ->color('success')
                                            ->icon('heroicon-o-currency-dollar')
                                            ->weight('bold'),
                                        TextEntry::make('product.name')
                                            ->label('Product')
                                            ->color('secondary')
                                            ->icon('phosphor-package')
                                            ->weight('bold'),
                                        TextEntry::make('productVariant.value')
                                            ->label('Variant')
                                            ->color('purple')
                                            ->icon('phosphor-tag')
                                            ->weight('bold'),
                                        TextEntry::make('quantity')
                                            ->label('Quantity')
                                            ->badge()
                                            ->icon(fn(int $state): string => $state > 20 ? 'heroicon-o-check-circle' :
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->badge()
                    ->color(fn($state, $record) => $record->status->statusColor)
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->alignCenter()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ])
            ->query(Order::where('user_id', auth()->id()));
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
            'index' => Pages\ListOrders::route('/')
        ];
    }
}
