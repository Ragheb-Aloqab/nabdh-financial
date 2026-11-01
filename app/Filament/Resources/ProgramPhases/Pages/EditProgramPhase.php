<?php

namespace App\Filament\Resources\ProgramPhases\Pages;

use App\Filament\Resources\ProgramPhases\ProgramPhaseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProgramPhase extends EditRecord
{
    protected static string $resource = ProgramPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
