<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PicklistResource\Pages;
use App\Filament\Resources\PicklistResource\RelationManagers;
use App\Models\Picklist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PicklistResource extends Resource
{
    protected static ?string $model = Picklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live()
                    ->debounce()
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ,
                Forms\Components\TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->hint(__('Slug is auto populated based on the "name" field'))
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPicklists::route('/'),
            'create' => Pages\CreatePicklist::route('/create'),
            'view' => Pages\ViewPicklist::route('/{record}'),
            'edit' => Pages\EditPicklist::route('/{record}/edit'),
        ];
    }
}
