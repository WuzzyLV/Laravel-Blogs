<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function toggleStatus(int $id): void
    {
        $post = Post::findOrFail($id);
        $post->update(['is_active' => ! $post->is_active]);
    }

    public function delete(int $id): void
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
    }

    public function paginationView(): string
    {
        return 'livewire.partials.pagination';
    }

    public function render()
    {
        return view('livewire.admin.posts.index', [
            'posts' => Post::latest('published_at')->paginate(15),
        ]);
    }
}
