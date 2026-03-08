<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        return view('livewire.admin.stats', [
            'totalPosts'   => Post::count(),
            'activePosts'  => Post::where('is_active', true)->count(),
            'totalViews'   => Post::sum('views'),
            'latestPost'   => Post::where('is_active', true)->latest('published_at')->value('published_at'),
        ]);
    }
}
