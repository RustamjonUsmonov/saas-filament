<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ReviewResource\Pages;
use App\Filament\User\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required(),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Section for Review Information
                Section::make('Review Information')
                    ->icon('phosphor-chat-circle-dots')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 3])
                            ->schema([
                                TextEntry::make('user.name')
                                    ->hiddenLabel()
                                    ->weight('bold')
                                    ->size(TextEntrySize::Large),

                                TextEntry::make('rating')
                                    ->label('Rating')
                                    ->badge()
                                    ->iconPosition('after')
                                    ->color(fn (int $state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'danger'))
                                    ->icon('heroicon-o-star'),

                                TextEntry::make('created_at')
                                    ->label('Review Date')
                                    ->size(TextEntrySize::Small)
                                    ->color('gray')
                                    ->weight('semibold'),
                            ]),

                        TextEntry::make('comment')
                            ->label('Review Comment')
                            ->columnSpanFull()
                            ->size(TextEntrySize::Large),

                    ])
                    ->collapsible(),

                // Section for Product Information Related to the Review
                Section::make('Product Information')
                    ->icon('phosphor-treasure-chest')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->size(TextEntrySize::Large),

                                TextEntry::make('product.price')
                                    ->label('Product Price')
                                    ->money('USD')
                                    ->badge()
                                    ->color('success')
                            ]),
                    ])
                    ->collapsible(),
                // Section for Product Information Related to the Review
                Section::make('Vendor Information')
                    ->icon('phosphor-storefront')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 3])
                            ->schema([
                                TextEntry::make('vendor.name')
                                    ->weight('bold')
                                    ->hiddenLabel()
                                    ->size(TextEntrySize::Large),

                                TextEntry::make('vendor.description')
                                    ->hiddenLabel()->weight('italic')
                            ]),
                        Actions::make([
                            Action::make('viewVendor')
                                ->label('Go to Store')
                                ->icon('phosphor-signpost')
                                ->color('warning')
                                ->action(function () {
                                    // Your action logic here
                                }),

                        ]),
                    ])
                    ->collapsible(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->icon('phosphor-star')
                    ->badge()
                    ->color(Color::Amber)
                    ->iconPosition('after')
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
                Tables\Actions\ViewAction::make(),
            ])
            ->groups([
                Group::make('vendor.name')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('rating')
                    ->collapsible(),
            ])
            ->defaultSort('created_at','desc')
            ->query(Review::where('user_id', auth()->id()));
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
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
