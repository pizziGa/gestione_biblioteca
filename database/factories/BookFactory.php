<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{

    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'ISBN' => $this->faker->isbn13(),
            'description' => $this->faker->text(),
            'year' => $this->faker->year(),
            'cover' => $this->faker->imageUrl(),
            'category_id' => 3,
        ];
    }
}
