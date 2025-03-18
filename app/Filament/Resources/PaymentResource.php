<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'phosphor-money';

    protected static ?string $navigationGroup = 'Payment Management';
    protected static ?int $navigationSort = 1;

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('payment_method_id')
                    ->relationship('paymentMethod', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('processed_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('processed_at')
                    ->dateTime()
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Payment Details')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->schema([
                                TextEntry::make('order.id')
                                    ->label('Order ID')
                                    ->weight('bold')
                                    ->icon('heroicon-o-receipt-refund'),

                                TextEntry::make('amount')
                                    ->label('Amount Paid')
                                    ->money('USD')
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-currency-dollar'),
                            ]),

                        Grid::make(['default' => 1, 'md' => 3])
                            ->schema([
                                TextEntry::make('paymentMethod.name')
                                    ->label('Payment Method')
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-o-credit-card'),

                                TextEntry::make('status')
                                    ->label('Payment Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        default => 'gray',
                                    })
                                    ->icon(fn(string $state): string => match ($state) {
                                        'completed' => 'heroicon-o-check-circle',
                                        'pending' => 'heroicon-o-clock',
                                        'failed' => 'heroicon-o-x-circle',
                                        default => 'heroicon-o-question-mark-circle',
                                    }),

                                TextEntry::make('processed_at')
                                    ->label('Processed At')
                                    ->dateTime(),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('User Details')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('User Name')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('user.email')
                                    ->label('Email')
                                    ->icon('phosphor-envelope-simple'),
                            ]),
                    ])
                    ->collapsible()
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
            'index' => Pages\ListPayments::route('/'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
