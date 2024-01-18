<?php

namespace App\Filament\Resources\ReturnProdctResource\Pages;

use App\Filament\Resources\ReturnProdctResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnProdcts extends ListRecords
{
    protected static string $resource = ReturnProdctResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
