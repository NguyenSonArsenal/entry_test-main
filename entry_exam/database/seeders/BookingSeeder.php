<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN');
        $hotelIds = Hotel::query()->orderBy('hotel_id', 'desc')->limit(10)->pluck('hotel_id')->toArray();

        for ($i = 0; $i < 1005; $i++) {
            $checkinTime = $faker->dateTimeBetween('-1 month', 'now');
            $checkoutTime = $faker->dateTimeBetween($checkinTime, $checkinTime->modify('+7 days'));
            Booking::create([
                'hotel_id' => $hotelIds[array_rand($hotelIds)],
                'customer_name' => $faker->unique()->name,
                'customer_contact' => $faker->text(255),
                'checkin_time' => $checkinTime,
                'checkout_time' => $checkoutTime,
            ]);
        }
    }
}

