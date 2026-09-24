<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Images stored on the public disk, grouped by folder.</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Images still used by site content are protected from deletion.</p>
            </div>
            <button
                type="button"
                wire:click="deleteSelectedFiles"
                wire:confirm="Delete the selected images? Images still in use will be protected."
                @disabled(empty($selectedFiles))
                class="inline-flex items-center gap-2 rounded-lg bg-danger-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-danger-500 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <x-heroicon-o-trash class="h-5 w-5" />
                Delete selected ({{ count($selectedFiles) }})
            </button>
        </div>

        @forelse ($this->folders as $folder)
            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-700">
                    <h2 class="font-semibold text-gray-950 dark:text-white">{{ $folder['name'] }}</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($folder['files']) }} image(s)</span>
                </div>
                <div class="grid grid-cols-2 gap-4 p-4 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6">
                    @foreach ($folder['files'] as $file)
                        <label class="group relative cursor-pointer overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                            <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file['path'] }}" class="absolute left-3 top-3 z-10 h-5 w-5 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" loading="lazy" class="aspect-square w-full object-cover transition group-hover:opacity-80">
                            <div class="p-2">
                                <p class="truncate text-xs font-medium text-gray-900 dark:text-white" title="{{ $file['name'] }}">{{ $file['name'] }}</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ number_format($file['size'] / 1024, 1) }} KB</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                No uploaded images were found on the public disk.
            </div>
        @endforelse
    </div>
</x-filament-panels::page>