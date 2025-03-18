<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\ProductTagResource\Pages;
use App\Filament\Resources\ProductTagResource\RelationManagers;
use App\Models\ProductTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ProductTagResource extends Resource
{
    protected static ?string $model = ProductTag::class;

    protected static ?string $navigationIcon = 'phosphor-hash';
    protected static ?string $navigationGroup = 'Product Management';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $records = ProductTag::paginate(12); // Fetch paginated tags
        return $table
            ->columns([]) // Remove all columns, as we are showing cards now
            ->actions([])
            ->bulkActions([])
            ->view('filament.tables.cards.product', compact('records'));
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
            'index' => \App\Filament\Admin\Resources\ProductTagResource\Pages\ListProductTags::route('/'),
            'create' => \App\Filament\Admin\Resources\ProductTagResource\Pages\CreateProductTag::route('/create'),
            'edit' => \App\Filament\Admin\Resources\ProductTagResource\Pages\EditProductTag::route('/{record}/edit'),
        ];
    }
}
