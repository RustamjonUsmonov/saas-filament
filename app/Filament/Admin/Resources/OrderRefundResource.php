<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\OrderRefundResource\Pages;
use App\Filament\Resources\OrderRefundResource\RelationManagers;
use App\Models\OrderRefund;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderRefundResource extends Resource
{
    protected static ?string $model = OrderRefund::class;

    protected static ?string $navigationIcon = 'phosphor-coins';

    protected static ?string $navigationGroup = 'Order Management';

    protected static ?int $navigationSort = 4;
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_return_id')
                    ->relationship('orderReturn', 'id')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('order_refund_status_id')
                    ->relationship('status', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('processed_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orderReturn.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->badge()
                    ->color('secondary')
                    ->sortable(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => \App\Filament\Admin\Resources\OrderRefundResource\Pages\ListOrderRefunds::route('/'),
            'create' => \App\Filament\Admin\Resources\OrderRefundResource\Pages\CreateOrderRefund::route('/create'),
            'edit' => \App\Filament\Admin\Resources\OrderRefundResource\Pages\EditOrderRefund::route('/{record}/edit'),
        ];
    }
}
