<?php

namespace Database\Factories;

use DateTime;
use DateTimeZone;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomDate = fake()->date('Y-m-d', 'now');
        $birthdays  = fake()->date('Y', 'now') . date('-m-d');
        $birthDate  = fake()->randomElement([$birthdays, $randomDate]);
        $gender     = fake()->randomElement(['male', 'female']);
        $code       = fake()->randomElement(array_keys(getCountries()));
        $city       = getRandomGeo($code);

        return [
            'first_name' => fake()->firstName($gender),
            'last_name'  => fake()->lastName($gender),
            'email'      => fake()->unique()->email(),
            'address'    => fake()->streetAddress(),
            'country'    => getCountryName($code),
            'city'       => $city->name,
            'timezone'   => $city->timezone,
            'birth_date' => $birthDate
        ];
    }
}
