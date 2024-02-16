<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'         => 2077456,
                'parent_id'  => null,
                'depth'      => 0,
                'name'       => 'Commonwealth of Australia',
                'alternames' => '[]',
                'country'    => 'AU',
                'a1code'     => '00',
                'level'      => 'PCLI',
                'population' => '24992369',
                'lat'        => '-25.000000',
                'long'       => '135.000000',
                'timezone'   => ''
            ],
            [
                'id'         => 2145234,
                'parent_id'  => 2077456,
                'depth'      => 1,
                'name'       => 'State of Victoria',
                'alternames' => '[]',
                'country'    => 'AU',
                'a1code'     => '07',
                'level'      => 'ADM1',
                'population' => '6613700',
                'lat'        => '-37.000000',
                'long'       => '145.000000',
                'timezone'   => 'Australia/Melbourne',
            ],
            [
                'id'         => 7839805,
                'parent_id'  => 2145234,
                'depth'      => 2,
                'name'       => 'Melbourne',
                'alternames' => '[]',
                'country'    => 'AU',
                'a1code'     => '07',
                'level'      => 'ADM2',
                'population' => '116447',
                'lat'        => '-37.813060',
                'long'       => '144.944220',
                'timezone'   => 'Australia/Melbourne',
            ],
            [
                'id'         => 1643084,
                'parent_id'  => null,
                'depth'      => 0,
                'name'       => 'Republic of Indonesia',
                'alternames' => '[]',
                'country'    => 'ID',
                'a1code'     => '00',
                'level'      => 'PCLI',
                'population' => '267663435',
                'lat'        => '-5.000000',
                'long'       => '120.000000',
                'timezone'   => ''
            ],
            [
                'id'         => 1642669,
                'parent_id'  => 1643084,
                'depth'      => 1,
                'name'       => 'Provinsi Jawa Tengah',
                'alternames' => '[]',
                'country'    => 'ID',
                'a1code'     => '07',
                'level'      => 'ADM1',
                'population' => '36742501',
                'lat'        => '-7.500000',
                'long'       => '110.000000',
                'timezone'   => 'Asia/Jakarta',
            ],
            [
                'id'         => 1627893,
                'parent_id'  => 1642669,
                'depth'      => 2,
                'name'       => 'Kota Semarang',
                'alternames' => '[]',
                'country'    => 'ID',
                'a1code'     => '07',
                'level'      => 'ADM2',
                'population' => '1659975',
                'lat'        => '-7.025000',
                'long'       => '110.385000',
                'timezone'   => 'Asia/Jakarta',
            ]
        ];

        DB::table('geo')->insert($data);
    }
}
