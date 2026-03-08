<div class="grid gap-4 md:grid-cols-3">

    <div class="flex flex-col justify-between rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-5">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Posts</span>
            <flux:icon name="document-text" class="size-5 text-neutral-400 dark:text-zinc-500" />
        </div>
        <div class="mt-4">
            <span class="text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $activePosts }}</span>
            <span class="ml-2 text-sm text-neutral-500 dark:text-neutral-400">of {{ $totalPosts }} total</span>
        </div>
    </div>

    <div class="flex flex-col justify-between rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-5">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Views</span>
            <flux:icon name="eye" class="size-5 text-neutral-400 dark:text-zinc-500" />
        </div>
        <div class="mt-4">
            <span class="text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ number_format($totalViews) }}</span>
            <span class="ml-2 text-sm text-neutral-500 dark:text-neutral-400">across all posts</span>
        </div>
    </div>

    <div class="flex flex-col justify-between rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-5">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Latest Post</span>
            <flux:icon name="calendar" class="size-5 text-neutral-400 dark:text-zinc-500" />
        </div>
        <div class="mt-4">
            @if ($latestPost)
                <span class="text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ \Carbon\Carbon::parse($latestPost)->format('d M') }}</span>
                <span class="ml-2 text-sm text-neutral-500 dark:text-neutral-400">{{ \Carbon\Carbon::parse($latestPost)->format('Y') }}</span>
            @else
                <span class="text-3xl font-bold text-neutral-500 dark:text-neutral-400">—</span>
            @endif
        </div>
    </div>

</div>
