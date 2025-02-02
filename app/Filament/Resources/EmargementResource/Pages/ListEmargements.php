<?php

namespace App\Filament\Resources\EmargementResource\Pages;

use App\Filament\Resources\EmargementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmargements extends ListRecords
{
    protected static string $resource = EmargementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
