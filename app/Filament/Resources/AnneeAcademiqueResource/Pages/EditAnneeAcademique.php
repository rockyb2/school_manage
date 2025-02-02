<?php

namespace App\Filament\Resources\AnneeAcademiqueResource\Pages;

use App\Filament\Resources\AnneeAcademiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnneeAcademique extends EditRecord
{
    protected static string $resource = AnneeAcademiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
