<?php

namespace App\Filament\Widgets;

use App\Models\Enseignant;
use App\Models\Classe;
use Filament\Widgets\Widget;

class TotalStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-stats-widget';

    public function getData(): array
    {
        return [
            'totalEnseignants' => Enseignant::count(),
            'totalClasses' => Classe::count(),
        ];
    }
}
