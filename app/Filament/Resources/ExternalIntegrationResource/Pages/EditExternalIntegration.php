<?php

namespace App\Filament\Resources\ExternalIntegrationResource\Pages;

use App\Filament\Resources\ExternalIntegrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExternalIntegration extends EditRecord
{
    protected static string $resource = ExternalIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
