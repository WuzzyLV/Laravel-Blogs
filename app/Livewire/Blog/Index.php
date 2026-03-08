<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.blog.index', [
            'posts' => Post::where('is_active', true)
                ->latest('published_at')
                ->paginate(9),
        ])->layout('layouts.public', ['title' => 'Blog']);
    }
}
