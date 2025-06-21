<?php

namespace App\Filament\Resources\EtudiantsResource\Pages;

use App\Filament\Resources\EtudiantsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEtudiants extends EditRecord
{
    protected static string $resource = EtudiantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
