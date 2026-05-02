<x-filament-panels::page>
    <div class="flex flex-col" style="gap: 2rem !important;">
        <!-- Formulário Admin Nativo (Importação) -->
        {{ $this->form }}

        <!-- Histórico de Backups Dinâmico via Filament Table -->
        <div style="margin-top: 0.5rem !important;">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
