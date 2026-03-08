<div class="flex flex-1 flex-col">

    <div class="flex items-center justify-between m-4">
        <flux:heading size="xl">Posts</flux:heading>
        <flux:button :href="route('admin.posts.create')" variant="primary" wire:navigate icon="plus">
            New Post
        </flux:button>
    </div>

    <div class="flex flex-1 flex-col overflow-hidden rounded-b-xl border-t border-neutral-200 dark:border-neutral-700">
        <table class="w-full text-sm">
            <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-zinc-900">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-400">Title</th>
                    <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-400">Published</th>
                    <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-400">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($posts as $post)
                    <tr class="bg-white dark:bg-zinc-800">
                        <td class="px-4 py-3 font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $post->title }}
                        </td>
                        <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">
                            {{ $post->published_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($post->is_active)
                                <flux:badge color="green">Active</flux:badge>
                            @else
                                <flux:badge color="zinc">Inactive</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    :href="route('admin.posts.edit', $post)"
                                    variant="ghost"
                                    size="sm"
                                    icon="pencil"
                                    wire:navigate
                                >
                                    Edit
                                </flux:button>
                                <flux:button
                                    wire:click="delete({{ $post->id }})"
                                    wire:confirm="Are you sure you want to delete this post?"
                                    variant="ghost"
                                    size="sm"
                                    icon="trash"
                                >
                                    Delete
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-neutral-500 dark:text-neutral-400">
                            No posts yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($posts->hasPages())
        <div class="p-4">{{ $posts->links() }}</div>
    @endif

</div>
