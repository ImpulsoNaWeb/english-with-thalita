<?php

namespace App\Filament\Resources\DepoimentoResource\Pages;

use App\Filament\Resources\DepoimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditarDepoimento extends EditRecord
{
    protected static string $resource = DepoimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        foreach ($this->record->getTranslatableAttributes() as $attribute) {
            $data[$attribute] = $this->record->getTranslations($attribute);
        }
 
        return $data;
    }
}
