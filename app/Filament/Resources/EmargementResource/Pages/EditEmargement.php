<?php

namespace App\Filament\Resources\EmargementResource\Pages;

use App\Filament\Resources\EmargementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmargement extends EditRecord
{
    protected static string $resource = EmargementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
