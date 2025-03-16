<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialiteUserResource\Pages;
use App\Models\SocialiteUser;
use Filament\Forms\Components\{DatePicker, Placeholder, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\{BulkActionGroup, DeleteAction, DeleteBulkAction, EditAction};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialiteUserResource extends Resource
{
    protected static ?string $model = SocialiteUser::class;

    protected static ?string $slug = 'socialite-users';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([//
                TextInput::make('user_id')
                    ->required()
                    ->integer(),

                TextInput::make('provider')
                    ->required(),

                TextInput::make('provider_id')
                    ->required(),

                DatePicker::make('expires_at')
                    ->label('Expires Date'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?SocialiteUser $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?SocialiteUser $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id'),

                TextColumn::make('provider'),

                TextColumn::make('provider_id'),

                TextColumn::make('expires_at')
                    ->label('Expires Date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSocialiteUsers::route('/'),
            'create' => Pages\CreateSocialiteUser::route('/create'),
            'edit'   => Pages\EditSocialiteUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
