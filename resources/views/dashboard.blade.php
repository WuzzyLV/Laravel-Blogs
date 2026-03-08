<x-layouts::app :title="__('Dashboard')">
    <div class="flex flex-1 flex-col gap-4">
        @livewire('admin.stats')
        <div class="flex flex-1 flex-col rounded-xl border border-neutral-200 dark:border-neutral-700">
            @livewire('admin.posts.index')
        </div>
    </div>
</x-layouts::app>
