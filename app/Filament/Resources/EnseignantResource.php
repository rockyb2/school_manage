<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnseignantResource\Pages;
use App\Filament\Resources\EnseignantResource\RelationManagers;
use App\Models\Enseignant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;

class EnseignantResource extends Resource
{
    protected static ?string $model = Enseignant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nom')
                ->required()
                ->maxLength(100),
                TextInput::make('prenoms')
                ->required()
                ->maxLength(100),
                TextInput::make('specialite')
                ->required()
                ->maxLength(100),
                TextInput::make('tel')
                ->numeric()
                ->required(),
                TextInput::make('email')
                ->label('Email Address')
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('mot_de_passe')
                    ->required()
                    ->password()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('prenoms')
                    ->sortable(),
                TextColumn::make('specialite')
                    ->sortable(),
                TextColumn::make('tel'),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('disponibilites')
                    ->label('Disponibilités')
                    ->formatStateUsing(function ($record) {
                        return $record->disponibilites->map(function ($dispo) {
                            return $dispo->jour . ' (' . $dispo->periode . ')';
                        })->join(', ');
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListEnseignants::route('/'),
            'create' => Pages\CreateEnseignant::route('/create'),
            'edit' => Pages\EditEnseignant::route('/{record}/edit'),
        ];
    }
}
