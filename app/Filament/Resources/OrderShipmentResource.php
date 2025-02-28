<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderShipmentResource\Pages;
use App\Filament\Resources\OrderShipmentResource\RelationManagers;
use App\Models\OrderShipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderShipmentResource extends Resource
{
    protected static ?string $model = OrderShipment::class;

    protected static ?string $navigationIcon = 'phosphor-truck';
    protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Forms\Components\TextInput::make('tracking_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('carrier')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->relationship('status', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('shipped_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('delivered_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('carrier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_shipment_status_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipped_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivered_at')
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
            'index' => Pages\ListOrderShipments::route('/'),
            'create' => Pages\CreateOrderShipment::route('/create'),
            'edit' => Pages\EditOrderShipment::route('/{record}/edit'),
        ];
    }
}
