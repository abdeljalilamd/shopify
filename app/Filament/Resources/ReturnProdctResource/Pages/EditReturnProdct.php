<?php

namespace App\Filament\Resources\ReturnProdctResource\Pages;

use App\Filament\Resources\ReturnProdctResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnProdct extends EditRecord
{
    protected static string $resource = ReturnProdctResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
