<?php

namespace App\Filament\Resources\EmailToBeSentResource\Pages;

use App\Filament\Resources\EmailToBeSentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmailToBeSents extends ManageRecords
{
    protected static string $resource = EmailToBeSentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No manual creation
        ];
    }
}