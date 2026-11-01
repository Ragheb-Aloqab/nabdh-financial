<?php

namespace App\Filament\Resources\RoadmapSteps\Pages;

use App\Filament\Resources\RoadmapSteps\RoadmapStepResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoadmapSteps extends ListRecords
{
    protected static string $resource = RoadmapStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
