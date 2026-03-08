<div>
    @if ($posts->isEmpty())
        <p class="text-center text-neutral-500 dark:text-neutral-400 py-20">No posts published yet.</p>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-blog.post-card :post="$post" />
            @endforeach
        </div>

        @if ($posts->hasPages())
            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    @endif
</div>
