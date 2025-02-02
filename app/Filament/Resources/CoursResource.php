<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoursResource\Pages;
use App\Filament\Resources\CoursResource\RelationManagers;
use App\Models\Cours;
use Carbon\Callback;
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
use Filament\Forms\Components\TimePicker;
use App\Models\Enseignant;
use App\Models\salles;
use Filament\Tables\Actions\ActionGroup;

class CoursResource extends Resource
{
    protected static ?string $model = Cours::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nom')
                ->required(),

            Select::make('classe_id')
                ->label('Classe')
                ->relationship('classes', 'nom_classe') // Relation correcte
                ->required(),

            Select::make('matiere_id')
                ->label('Matière')
                ->relationship('matieres', 'nom_matiere') // Relation correcte
                ->required(),

                Select::make('jour')
                ->label('Jour')
                ->options([
                    'lundi' => 'Lundi',
                    'mardi' => 'Mardi',
                    'mercredi' => 'Mercredi',
                    'jeudi' => 'Jeudi',
                    'vendredi' => 'Vendredi',
                    'samedi' => 'Samedi',
                ])
                ->reactive()
                ->afterStateUpdated(fn (callable $set) =>$set('enseignant_id',null))
                ->placeholder('Choisir un jour'),



                Select::make('heure_debut')
                ->label('Heure Début')
                ->options([
                    '08:00' => '08:00',
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '12:00' => '12:00',
                    '13:00' => '13:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                ])
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('enseignant_id',null))
                ->default('08:00'),

                Select::make('heure_fin')
                ->label('Heure Fin')
                ->options([
                    '08:30' => '08:30',
                    '09:30' => '09:30',
                    '10:30' => '10:30',
                    '11:30' => '11:30',
                    '12:30' => '12:30',
                    '13:30' => '13:30',
                    '14:30' => '14:30',
                    '15:30' => '15:30',
                    '16:30' => '16:30',
                    '17:00' => '17:00',
                ])
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('enseignant_id',null))
                ->default('08:30'),

            Select::make('enseignant_id')
                ->label('Enseignant')
                ->options(function(callable $get){
                    $jour = $get('jour');
                    $heure_debut = $get('heure_debut');
                    $heure_fin = $get('heure_fin');
                    $periode = str_replace(':','H',$heure_debut)."-".str_replace(':','H',$heure_fin);

                    if (!$jour || !$periode) {
                        return [];
                    }

                     // Filtrer les enseignants disponibles
                    $enseignantsDisponibles = Enseignant::whereHas('disponibilites', function ($query) use ($jour, $periode) {
                        $query->where('jour', $jour)->where('periode', $periode);
                    });
                     // Exclure les enseignants qui ont déjà un cours à la même période
        $enseignantsDisponibles = $enseignantsDisponibles->whereDoesntHave('cours', function ($query) use ($jour, $heure_debut, $heure_fin) {
            $query->where('jour', $jour)
                  ->where(function ($query) use ($heure_debut, $heure_fin) {
                      $query->where('heure_debut', '<=', $heure_fin)
                            ->where('heure_fin', '>=', $heure_debut);
                  });
        })->pluck('nom', 'id')->toArray();

        if (empty($enseignantsDisponibles)) {
            return ['' => 'Aucun enseignant disponible'];
        }

        return $enseignantsDisponibles;
                })
                ->required(),

            Select::make('salles_id')
                ->label('Salle')
                ->options(function(callable $get){
                    $jour = $get('jour');
                    $heure_debut = $get('heure_debut');
                    $heure_fin = $get('heure_fin');
                    $periode = str_replace(':','H',$heure_debut)."-".str_replace(':','H',$heure_fin);

                    if (!$jour || !$periode) {
                        return [];
                    }

                    $salles = Salles::whereDoesntHave('cours', function ($query) use ($jour, $periode) {
                        $query->where('jour', $jour)
                              ->where(function ($query) use ($periode) {
                                  $query->where('heure_debut', '<=', $periode)
                                        ->where('heure_fin', '>=', $periode);
                              });
                    })->pluck('nom_salle', 'id')->toArray();

                    if (empty($salles)) {
                        return ['' => 'Aucune salle disponible'];
                    }
                    return $salles;
                })
                ->required(),

                // Champs pour l'emploi du temps (non enregistrés dans le modèle cours)
                Select::make('annee_academique_id')
                    ->label('Année Académique')
                    ->options(\App\Models\Annee_academique::pluck('annee', 'id')->toArray())
                    ->required(),

                Select::make('semestre_id')
                    ->label('Semestre')
                    ->options(\App\Models\Semestre::pluck('nom_semestre', 'id')->toArray())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('enseignants.nom')
                    ->searchable(),
                TextColumn::make('classes.nom_classe')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('matieres.nom_matiere')
                    ->searchable(),
                TextColumn::make('Jour')
                    ->searchable(),
                TextColumn::make('heure_debut')
                    ->searchable(),
                TextColumn::make('heure_fin')
                    ->searchable(),
                TextColumn::make('salles.nom_salle')
                    ->searchable(),
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
            'index'  => Pages\ListCours::route('/'),
            'create' => Pages\CreateCours::route('/create'),
            'edit'   => Pages\EditCours::route('/{record}/edit'),
        ];
    }
}
