<div class="flex h-full w-full flex-1 flex-col gap-6 max-w-3xl">

    <div class="flex items-center gap-3">
        <flux:button :href="route('dashboard')" variant="ghost" icon="arrow-left" wire:navigate />
        <flux:heading size="xl">{{ $post?->exists ? 'Edit Post' : 'New Post' }}</flux:heading>
    </div>

    <form wire:submit="save" class="flex flex-col gap-6">

        <flux:field>
            <flux:label>Title</flux:label>
            <flux:input wire:model="title" placeholder="Post title" />
            <flux:error name="title" />
        </flux:field>

        <flux:field>
            <flux:label>Body</flux:label>
            <div
                x-data="{
                    body: @entangle('body'),
                    init() {
                        const editor = this.$refs.trix;
                        editor.addEventListener('trix-change', () => {
                            this.body = editor.value;
                        });
                        if (this.body) {
                            editor.editor.insertHTML(this.body);
                        }
                    }
                }"
            >
                <input id="trix-body" type="hidden" />
                <trix-editor
                    x-ref="trix"
                    input="trix-body"
                    class="rounded-lg border border-neutral-300 bg-white p-3 dark:border-neutral-600 dark:bg-zinc-700 dark:text-white min-h-64"
                ></trix-editor>
            </div>
            <flux:error name="body" />
        </flux:field>

        <flux:field>
            <flux:label>Publish Date</flux:label>
            <flux:input type="date" wire:model="published_at" />
            <flux:error name="published_at" />
        </flux:field>

        <flux:field>
            <div class="flex items-center gap-3">
                <flux:switch wire:model="is_active" />
                <flux:label>Active</flux:label>
            </div>
        </flux:field>

        <flux:field>
            <flux:label>Image <span class="text-neutral-400">(optional)</span></flux:label>

            @if ($existingImage && ! $image)
                <div class="flex items-start gap-4">
                    <img src="{{ $existingImage }}" alt="Current image" class="h-32 w-auto rounded-lg object-cover" />
                    <flux:button wire:click="removeImage" variant="ghost" size="sm" icon="trash">
                        Remove
                    </flux:button>
                </div>
            @endif

            @if ($image)
                <div class="mb-2">
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-32 w-auto rounded-lg object-cover" />
                </div>
            @endif

            <flux:input type="file" wire:model="image" accept="image/*" />
            <flux:error name="image" />
        </flux:field>

        <div class="flex gap-3">
            <flux:button type="submit" variant="primary">
                {{ $post?->exists ? 'Save Changes' : 'Create Post' }}
            </flux:button>
            <flux:button :href="route('dashboard')" variant="ghost" wire:navigate>
                Cancel
            </flux:button>
        </div>

    </form>
</div>
