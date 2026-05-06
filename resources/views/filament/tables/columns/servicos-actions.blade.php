<div class="flex items-center gap-x-3 justify-end px-3">
    <a href="{{ \App\Filament\Resources\ServicoResource::getUrl('edit', ['record' => $getRecord()]) }}" class="fi-link fi-color-primary flex items-center gap-1 text-sm font-medium hover:underline">
        <x-heroicon-m-pencil-square class="w-4 h-4" />
        Editar
    </a>
    <button 
        wire:click="mountTableAction('delete', '{{ $getRecord()->getKey() }}')"
        wire:loading.attr="disabled"
        class="fi-link fi-color-danger flex items-center gap-1 text-sm font-medium hover:underline text-danger-600"
    >
        <x-heroicon-m-trash class="w-4 h-4" />
        Excluir
    </button>
</div>
