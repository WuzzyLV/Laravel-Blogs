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

        $seen = session()->get('viewed_posts', []);

        if (! in_array($this->post->id, $seen)) {
            $this->post->increment('views');
            session()->push('viewed_posts', $this->post->id);
        }
    }

    public function render()
    {
        $seen = session()->get('viewed_posts', []);

        $recommendations = Post::where('is_active', true)
            ->whereNotIn('id', $seen)
            ->where('id', '!=', $this->post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('livewire.blog.show', compact('recommendations'))
            ->layout('layouts.public', ['title' => $this->post->title]);
    }
}
