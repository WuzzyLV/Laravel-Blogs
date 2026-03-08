@props(['post', 'compact' => false])

<a href="{{ route('blog.show', $post->slug) }}"
   class="group flex flex-col overflow-hidden rounded-xl border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:border-neutral-400 dark:hover:border-zinc-500 transition-colors">

    <div class="aspect-video w-full overflow-hidden bg-neutral-100 dark:bg-zinc-700">
        @if ($post->image_url)
            <img
                src="{{ $post->image_url }}"
                alt="{{ $post->title }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
            >
        @else
            <div class="flex h-full items-center justify-center text-neutral-400 dark:text-zinc-500">
                <flux:icon name="photo" class="{{ $compact ? 'size-8' : 'size-10' }}" />
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col {{ $compact ? 'p-3' : 'p-4' }}">
        @if ($compact)
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                {{ $post->published_at->format('d M Y') }}
            </p>
        @endif
        <h3 class="font-semibold text-neutral-900 dark:text-neutral-100 group-hover:underline line-clamp-2 {{ $compact ? 'text-sm' : '' }}">
            {{ $post->title }}
        </h3>
        @if (! $compact)
            <p class="mt-auto pt-3 text-xs text-neutral-500 dark:text-neutral-400">
                {{ $post->published_at->format('d M Y') }}
            </p>
        @endif
    </div>

</a>
