<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog.show')
            ->layout('layouts.public', ['title' => $this->post->title]);
    }
}
