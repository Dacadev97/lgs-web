<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit" class="mt-4">
            Subir PDFs y crear composiciones
        </x-filament::button>
    </form>
</x-filament-panels::page>
