<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $images = ['Skateboard-PNG.png', 'téléchargement.jpg'];
        $image = $images[array_rand($images)];

        // Use the config function to get the app url
        $appUrl = config('app.url');

        // Use the app url to generate a URL for the image
        $imageUrl = $appUrl . '/storage/product_images/' . $image;

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->numberBetween(1, 100),
            'image' => $imageUrl,
        ];
    }
}
