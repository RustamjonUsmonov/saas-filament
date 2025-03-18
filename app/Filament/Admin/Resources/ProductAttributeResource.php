<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Resources\ProductAttributeResource\Pages;
use App\Filament\Resources\ProductAttributeResource\RelationManagers;
use App\Models\ProductAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;

    protected static ?string $navigationIcon = 'phosphor-grid-four';
    protected static ?string $navigationGroup = 'Product Management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter name')
                            ->autocapitalize('words')
                            ->autocomplete(false)
                            ->columnSpanFull()
                            ->helperText('This name will be displayed throughout the system.')
                            ->autofocus(),
                    ])
                    ->description('Basic information')
                    ->collapsible(false)
                    ->compact(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->description(fn($record) => 'ID: ' . $record->id)
                    ->copyable()
                    ->extraAttributes(['class' => 'px-4 py-3']),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignEnd(),
            ])
            ->filters([
                // Your existing filters
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->searchable()
            ->defaultSort('created_at', 'desc')
            ->poll('60s')
            ->emptyStateHeading('No records found')
            ->emptyStateDescription('Create your first record to get started.')
            ->emptyStateIcon('heroicon-o-document-text');
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
            'index' => \App\Filament\Admin\Resources\ProductAttributeResource\Pages\ListProductAttributes::route('/'),
            'create' => \App\Filament\Admin\Resources\ProductAttributeResource\Pages\CreateProductAttribute::route('/create'),
            'edit' => \App\Filament\Admin\Resources\ProductAttributeResource\Pages\EditProductAttribute::route('/{record}/edit'),
        ];
    }
}
