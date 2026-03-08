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
            'title'        => $this->faker->sentence(rand(4, 9), true),
            'body'         => $this->fakeBody(),
            'image'        => null,
            'published_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'is_active'    => $this->faker->boolean(80),
        ];
    }

    private function fakeBody(): string
    {
        $paragraphs = $this->faker->paragraphs(rand(3, 6));

        $html = '<div>';
        foreach ($paragraphs as $p) {
            $html .= '<p>' . $p . '</p>';
        }
        $html .= '</div>';

        return $html;
    }
}
