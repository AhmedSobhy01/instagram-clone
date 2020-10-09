<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $images = [
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/88230708_488598838481484_3400156485246348005_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=100&_nc_ohc=Y2EeWTpM_3QAX98OQK7&_nc_tp=18&oh=e0a4f39fd08aa7b04c94aa344c7c5f20&oe=5FA6EF07",
        'https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/120844151_179093780427359_2533136887294926925_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=6b0q7TKaS9IAX_Xkuyy&_nc_tp=15&oh=45e701e922a2b569a16d6ba4b4a93ef2&oe=5FA6A727',
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/118980372_3202566573155194_3827968125985386401_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=110&_nc_ohc=wWiHYr_JWBYAX_-kZ8q&_nc_tp=15&oh=e42e4381d241ec905cf499d1129e782c&oe=5FA8A8C8",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/118519405_428566101436046_3651425515563872710_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=Bjf2RCzn3HoAX8tmf1x&_nc_tp=15&oh=b09e17367dddfb4cb36ddd2bdb50330a&oe=5FA8E795",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/p1080x1080/117379317_300527608057650_8840774627987993022_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=H-QEnth0kIUAX_pvslp&_nc_tp=19&oh=b53be4e047284fea3ec449b6348e27bc&oe=5FA809C1",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/p1080x1080/90068474_122635915994994_7971647434267840263_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=IwgX_wIWFaEAX-VoBR3&_nc_tp=19&oh=ac1a3223f6519f3455856286efa16d49&oe=5FA6DAB4",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/119816356_628123141426954_7218994917738408794_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=FRLZ2nMopccAX_P_AoJ&_nc_tp=15&oh=b1e599a91728124d58df74394a24cc29&oe=5FA7D994",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/s1080x1080/120069314_211747917187459_6325010390726941079_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=3zOr0R2z7T4AX_TI-fM&_nc_tp=15&oh=7fe01a5c1d77e4a422fc38cf376c8e4e&oe=5FA82898",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/p1080x1080/118615563_2701977750083669_263536402305518690_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=105&_nc_ohc=4XB9jyZ1GawAX-MmXIz&_nc_tp=19&oh=32550318b2f8651b368d982c136a815f&oe=5FA6B403",
        "https://instagram.faly3-1.fna.fbcdn.net/v/t51.2885-15/e35/121066075_4089560364403672_5117915919221383026_n.jpg?_nc_ht=instagram.faly3-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=BUy6rHhNE_wAX92ouLr&_nc_tp=18&oh=5f7a38a6923a120ea835ce3f61e88fec&oe=5FA90168"
    ];
    return [
        'image' => $faker->randomElement($images),
        'caption' => $faker->text,
        'user_id' => random_int(1, User::count()),
    ];
});