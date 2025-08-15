<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClasseResource\Pages;
use App\Filament\Resources\ClasseResource\RelationManagers;
use App\Models\Classe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ActionGroup;

class ClasseResource extends Resource
{
    protected static ?string $model = Classe::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('filiere_id')
                ->label('Filière')
                ->relationship('filiere', 'nom_filiere') // Relation définie dans le modèle Filiere
                ->required(),
            TextInput::make('nom_classe')
                ->label('Nom de la Classe')
                ->required()
                ->maxLength(100),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom_classe')
                ->label('Nom de la Classe')
                ->searchable(),
            TextColumn::make('filiere.nom_filiere') // Relation et champ lié
                ->label('Filière')
                ->sortable(),
            
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
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasse::route('/create'),
            'edit' => Pages\EditClasse::route('/{record}/edit'),
        ];
    }
}
