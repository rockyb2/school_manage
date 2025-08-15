<?php

namespace App\Filament\Resources\CoefficentsResource\Pages;

use App\Filament\Resources\CoefficentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoefficents extends ListRecords
{
    protected static string $resource = CoefficentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
