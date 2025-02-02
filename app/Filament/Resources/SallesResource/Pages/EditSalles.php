<?php

namespace App\Filament\Resources\SallesResource\Pages;

use App\Filament\Resources\SallesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalles extends EditRecord
{
    protected static string $resource = SallesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
