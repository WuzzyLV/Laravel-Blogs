<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public string $title = '';
    public string $body = '';
    public string $published_at = '';
    public bool $is_active = true;
    public $image = null;
    public ?string $existingImage = null;

    public function mount(?Post $post = null): void
    {
        if ($post?->exists) {
            $this->post          = $post;
            $this->title         = $post->title;
            $this->body          = $post->body;
            $this->published_at  = $post->published_at->format('Y-m-d');
            $this->is_active     = $post->is_active;
            $this->existingImage = $post->image_url;
        } else {
            $this->published_at = now()->format('Y-m-d');
        }
    }

    public function save(): void
    {
        $this->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'image'        => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->post?->image;

        if ($this->image) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->image->store('posts', 'public');
        }

        $data = [
            'title'        => $this->title,
            'body'         => $this->body,
            'published_at' => $this->published_at,
            'is_active'    => $this->is_active,
            'image'        => $imagePath,
        ];

        if ($this->post?->exists) {
            $this->post->update($data);
        } else {
            Post::create($data);
        }

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function removeImage(): void
    {
        if ($this->post?->image) {
            Storage::disk('public')->delete($this->post->image);
            $this->post->update(['image' => null]);
            $this->existingImage = null;
        }

        $this->image = null;
    }

    public function render()
    {
        $title = $this->post?->exists ? 'Edit Post' : 'New Post';

        return view('livewire.admin.posts.form')
            ->layout('layouts.app', ['title' => $title]);
    }
}
