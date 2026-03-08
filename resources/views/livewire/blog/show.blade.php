<div class="mx-auto max-w-2xl">

    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-1 text-sm text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors mb-8">
        <flux:icon name="arrow-left" class="size-4" />
        Back to all posts
    </a>

    @if ($post->image_url)
        <div class="mb-8 overflow-hidden rounded-xl aspect-video bg-neutral-100 dark:bg-zinc-700">
            <img
                src="{{ $post->image_url }}"
                alt="{{ $post->title }}"
                class="h-full w-full object-cover"
            >
        </div>
    @endif

    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-3">
        {{ $post->published_at->format('d M Y') }}
    </p>

    <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-100 mb-8">
        {{ $post->title }}
    </h1>

    <div class="trix-content max-w-none">
        {!! $post->body !!}
    </div>

    @if ($recommendations->isNotEmpty())
        <div class="mt-16 border-t border-neutral-200 dark:border-zinc-700 pt-10">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-6">
                You might also like
            </h2>

            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ($recommendations as $rec)
                    <x-blog.post-card :post="$rec" :compact="true" />
                @endforeach
            </div>
        </div>
    @endif

</div>
