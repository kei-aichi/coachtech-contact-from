<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'first_name' => fake()->randomElement([
                '太郎',
                '花子',
                '健太',
                '美咲',
                '翔',
            ]),
            'last_name' => fake()->randomElement([
                '佐藤',
                '鈴木',
                '高橋',
                '田中',
                '伊藤',
            ]),
            'gender' => fake()->randomElement([1, 2, 3]),
            'email' => fake()->safeEmail(),
            'tel' => fake()->numerify('090########'),
            'address' => fake()->randomElement([
                '東京都渋谷区千駄ヶ谷1-2-3',
                '東京都新宿区西新宿2-8-1',
                '大阪府大阪市北区梅田3-1-1',
                '愛知県名古屋市中区栄1-1-1',
                '愛知県半田市青山2-3-4',
            ]),
            'building' => fake()->randomElement([
                '千駄ヶ谷マンション101',
                '新宿ハイツ202',
                '梅田ビル303',
                '栄レジデンス405',
                null,
            ]),
            'detail' => fake()->randomElement([
                '商品がまだ届いていません。配送状況を確認したいです。',
                '届いた商品のサイズが合わなかったため交換を希望します。',
                '商品に傷が付いていたため対応をお願いします。',
                '返品の手続き方法について教えてください。',
                '次回入荷予定日を教えてください。',
            ]),
        ];
    }
}
