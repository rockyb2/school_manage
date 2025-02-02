<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SallesResource\Pages;
use App\Filament\Resources\SallesResource\RelationManagers;
use App\Models\Salles;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use PhpParser\Node\Stmt\Label;

class SallesResource extends Resource
{
    protected static ?string $model = Salles::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nom_salle')
                ->required()
                ->maxLength(100),

                TextInput::make('capacite')
                ->required()
                ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('nom_salle')
              ->label('nom de la salle'),
              TextColumn::make('capacite')
              ->label('capacité')

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
            'index' => Pages\ListSalles::route('/'),
            'create' => Pages\CreateSalles::route('/create'),
            'edit' => Pages\EditSalles::route('/{record}/edit'),
        ];
    }
}
