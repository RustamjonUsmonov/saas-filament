<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderReturnResource\Pages;
use App\Filament\Resources\OrderReturnResource\RelationManagers;
use App\Models\OrderReturn;
use App\Models\OrderReturnStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderReturnResource extends Resource
{
    protected static ?string $model = OrderReturn::class;

    protected static ?string $navigationIcon = 'phosphor-arrow-u-down-left';

    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('order_id')
                                    ->label('Order')
                                    ->relationship('orderItem.order', 'id')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "Order #{$record->id}")
                                    ->required()
                                    ->reactive(),

                                Forms\Components\Select::make('order_item_id')
                                    ->label('Order Item')
                                    ->options(fn(Get $get) => \App\Models\OrderItem::where('order_id', $get('order_id'))
                                        ->get()
                                        ->mapWithKeys(fn($item) => [
                                            $item->id => "Product: {$item->product->name} | Variant: {$item->productVariant?->value} | Qty: {$item->quantity} | Price: {$item->price}"
                                        ])
                                    )
                                    ->required()
                                    ->reactive()
                                    ->disabled(fn(Get $get) => !$get('order_id')),
                            ]),
                    ]),

                Forms\Components\Section::make('Return Details')
                    ->schema([
                        Forms\Components\Textarea::make('reason')
                            ->label('Reason for Return')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Radio::make('order_return_status_id')
                                    ->label('Return Status')
                                    ->options(fn() => \App\Models\OrderReturnStatus::pluck('name', 'id')->toArray())
                                    ->required()
                                    ->columns(3),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orderItem.id')
                    ->label('Order Item ID')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('orderItem.product.name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('orderItem.quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('returnStatus.name')
                    ->label('Return Status')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_return_status_id')
                    ->label('Filter by Return Status')
                    ->options(
                        OrderReturnStatus::pluck('name', 'id')
                            ->sort()
                    )
                    ->placeholder('Filter by status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->tooltip('Delete selected records'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOrderReturns::route('/'),
            'create' => Pages\CreateOrderReturn::route('/create'),
            'edit' => Pages\EditOrderReturn::route('/{record}/edit'),
        ];
    }
}
