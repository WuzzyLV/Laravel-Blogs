<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(rand(4, 9), true),
            'body'         => $this->fakeBody(),
            'image'        => null,
            'published_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_active'    => fake()->boolean(80),
        ];
    }

    private function fakeBody(): string
    {
        $paragraphs = fake()->paragraphs(rand(3, 6));

        $html = '<div>';
        foreach ($paragraphs as $p) {
            $html .= '<p>' . $p . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}
