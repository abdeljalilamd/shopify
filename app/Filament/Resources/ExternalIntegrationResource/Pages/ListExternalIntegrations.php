<?php

namespace App\Filament\Resources\ExternalIntegrationResource\Pages;

use App\Filament\Resources\ExternalIntegrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExternalIntegrations extends ListRecords
{
    protected static string $resource = ExternalIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
