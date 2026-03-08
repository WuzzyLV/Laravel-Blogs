<div class="mx-auto max-w-2xl">

    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-1 text-sm text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors mb-8">
        <flux:icon name="arrow-left" class="size-4" />

        Back to all posts
    </a>


    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-3">
        {{ $post->published_at->format('d M Y') }}
    </p>

    <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-100 mb-8">
        {{ $post->title }}
    </h1>

    <div class="trix-content max-w-none">
        {!! $post->body !!}
    </div>

</div>
