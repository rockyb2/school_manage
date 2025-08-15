<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtudiantsResource\Pages;
use App\Filament\Resources\EtudiantsResource\RelationManagers;
use App\Models\Etudiants;
use Dom\Text;
use Dompdf\FrameDecorator\Image;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Tables\Actions\ActionGroup;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EtudiantsResource extends Resource
{
    protected static ?string $model = Etudiants::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Informations Générales')->schema([
                        TextInput::make('matricule')
                            ->label('Matricule')
                            ->readOnly()
                            ->dehydrated(false),
                        TextInput::make('nom')
                            ->required()
                            ->label('Nom')
                            ->maxLength(255),
                        TextInput::make('prenoms')
                            ->required()
                            ->label('Prénoms')
                            ->maxLength(255),

                        TextInput::make('age')
                            ->required()
                            ->label('Âge')
                            ->numeric()
                            ->maxValue(120)
                            ->minValue(0),

                        Select::make('sexe')

                            ->options([
                                'Masculin' => 'M',
                                'Féminin' => 'F',
                            ])
                            ->required()
                            ->label('Sexe')

                    ])->columns(2),

                    Section::make('Contact et Informations Personnelles')->schema([
                        TextInput::make('tel_etudiant')
                            ->required()
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(15),

                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->label('Email')
                            ->maxLength(255),

                        DatePicker::make('date_naissance')
                            ->date()
                            ->label('Date de Naissance'),

                        TextInput::make('lieu_naissance')
                            ->label('Lieu de Naissance')
                            ->maxLength(255),

                        TextInput::make('nationalité')
                            ->label('Nationalité')
                            ->maxLength(100),

                        Select::make('classe_id')
                            ->label('Classe')
                            ->relationship('classe', 'nom_classe')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->columns(2),





                ]),

                Group::make()->schema([
                    Section::make('Informations Familiales')->schema([
                        TextInput::make('nom_pere')
                            ->label('Nom du Père')
                            ->maxLength(255),

                        TextInput::make('nom_mere')
                            ->label('Nom de la Mère')
                            ->maxLength(255),

                        TextInput::make('nom_tuteur')
                            ->label('Nom du Tuteur')
                            ->maxLength(255),

                        TextInput::make('tel_pere')
                            ->label('Téléphone du Père')
                            ->tel()
                            ->maxLength(15),

                        TextInput::make('tel_mere')
                            ->label('Téléphone de la Mère')
                            ->tel()
                            ->maxLength(15),

                        TextInput::make('tel_tuteur')
                            ->label('Téléphone du Tuteur')
                            ->tel()
                            ->maxLength(15),
                    ])->columns(2),

                    Section::make('Inscription')->schema([
                        DatePicker::make('date_inscription')
                            ->label('Date d\'Inscription')
                            ->required(),
                    ]),

                    Section::make('Photo')->schema([
                        FileUpload::make('photo')
                            ->label('Photo de l\'Étudiant')
                            ->image()
                            ->maxSize('3072')
                            ->required()
                            ->directory('etudiants_photos'),
                    ]),


                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Photo')


                    ->circular(),


               TextColumn::make('matricule')
                    ->label('Matricule')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nom')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('prenoms')
                    ->label('Prénoms')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('classe.nom_classe')
                    ->label('Classe')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Âge')
                    ->sortable(),
                TextColumn::make('sexe')
                    ->label('Sexe')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date_inscription')
                    ->label('Date d\'Inscription')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListEtudiants::route('/'),
            'create' => Pages\CreateEtudiants::route('/create'),
            'edit' => Pages\EditEtudiants::route('/{record}/edit'),
        ];
    }
}
