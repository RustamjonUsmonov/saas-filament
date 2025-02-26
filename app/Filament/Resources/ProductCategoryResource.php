<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Filament\Resources\ProductCategoryResource\RelationManagers;
use App\Filament\Tables\Columns\BadgesColumn;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Product Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 3,
                    'lg' => 3,
                    'xl' => 3,
                ])->schema([
                    Forms\Components\Section::make('Basic Information')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('parent_id')
                                ->relationship('parent', 'name')
                                ->label('Parent Category'),
                        ])
                        ->columnSpan([
                            'default' => 1,
                            'md' => 1,
                        ]),

                    Forms\Components\Section::make('Child Categories')
                        ->schema([
                            Repeater::make('children')
                                ->relationship('children')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ])
                                ->addable(true)
                                ->deletable(true)
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string =>
                                    $state['name'] ?? null),
                        ])
                        ->columnSpan([
                            'default' => 1,
                            'md' => 2,
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->badge()->color(Color::Amber)
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->badge()
                    ->sortable(),
                BadgesColumn::make('children.name')
                    ->label('Subcategories')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('children_count')
                    ->label('Subcategories')
                    ->counts('children')
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
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}
