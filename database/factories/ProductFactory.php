<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'preview' => $this->preview(),
            'code' => $this->code(),
            'price' => mt_rand(100, 9999) / 100,
            'category_id' => mt_rand(11, 60)
        ];
    }

    protected function preview(): array
    {
        return [
            'mobile' => [
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
                asset('storage/images/mobile/' . mt_rand(1, 4) . '.png'),
            ],
            'desktop' => [
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
                asset('storage/images/desktop/' . mt_rand(1, 3) . '.png'),
            ]
        ];
    }

    protected function code()
    {
        return [
            'html' => file_get_contents(public_path('storage/codes/html/' . mt_rand(1, 3))),
            'vue' => file_get_contents(public_path('storage/codes/vue/' . mt_rand(1, 3))),
            'react' => file_get_contents(public_path('storage/codes/react/' . mt_rand(1, 3))),
        ];
    }
}
