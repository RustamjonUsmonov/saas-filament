<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\UserAddressResource\Pages;
use App\Filament\User\Resources\UserAddressResource\RelationManagers;
use App\Models\UserAddress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserAddressResource extends Resource
{
    protected static ?string $model = UserAddress::class;

    protected static ?string $navigationIcon = 'phosphor-map-pin-area';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Address Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('country')
                                ->label('Country')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter your country'),

                            Forms\Components\TextInput::make('state')
                                ->label('State/Province')
                                ->maxLength(255)
                                ->placeholder('Enter your state or province'),

                            Forms\Components\TextInput::make('city')
                                ->label('City')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter your city'),

                            Forms\Components\TextInput::make('postal_code')
                                ->label('Postal Code')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter postal code')
                                ->helperText('Postal code or ZIP code of your address'),

                            Forms\Components\TextInput::make('address_line1')
                                ->label('Address Line 1')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter the first line of the address')
                                ->helperText('Street address, P.O. box, company name, etc.'),

                            Forms\Components\TextInput::make('address_line2')
                                ->label('Address Line 2 (optional)')
                                ->maxLength(255)
                                ->placeholder('Enter second line of the address (if any)')
                                ->helperText('Apartment, suite, unit, building, floor, etc.'),

                        ])
                            ->columnSpan(2),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address_line1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_line2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
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
                Tables\Actions\EditAction::make()
                    ->icon('phosphor-sword'),
                Tables\Actions\DeleteAction::make()
                    ->icon('phosphor-fire')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->query(UserAddress::where('user_id', auth()->id()));
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
            'index' => Pages\ListUserAddresses::route('/'),
            'create' => Pages\CreateUserAddress::route('/create'),
            'edit' => Pages\EditUserAddress::route('/{record}/edit'),
        ];
    }
}
