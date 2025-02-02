<?php

namespace App\Filament\Resources\MatieresResource\Pages;

use App\Filament\Resources\MatieresResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatieres extends EditRecord
{
    protected static string $resource = MatieresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
