<x-filament-panels::page>
    <form wire:submit="salvar" class="space-y-6">
        {{ $this->form }}

        <div class="mt-6 flex justify-end" style="margin-top: 1.5rem !important;">
            <x-filament::button type="submit" size="lg">
                Salvar Alterações
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
