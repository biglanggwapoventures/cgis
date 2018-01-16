<?php

namespace App\Programs;

final class FeedingProgramReference
{

    private static $reference = [
        ['day' => '0', 'weight' => 42, 'dfc_factor' => 0.28, 'dfc_optimal' => 14],
        ['day' => '1', 'weight' => 52, 'dfc_factor' => 0.28, 'dfc_optimal' => 14],
        ['day' => '2', 'weight' => 66, 'dfc_factor' => 0.32, 'dfc_optimal' => 16],
        ['day' => '3', 'weight' => 81, 'dfc_factor' => 0.32, 'dfc_optimal' => 16],
        ['day' => '4', 'weight' => 100, 'dfc_factor' => 0.42, 'dfc_optimal' => 21],
        ['day' => '5', 'weight' => 122, 'dfc_factor' => 0.42, 'dfc_optimal' => 21],
        ['day' => '6', 'weight' => 148, 'dfc_factor' => 0.48, 'dfc_optimal' => 24],
        ['day' => '7', 'weight' => 177, 'dfc_factor' => 0.48, 'dfc_optimal' => 24],
        ['day' => '8', 'weight' => 208, 'dfc_factor' => 0.60, 'dfc_optimal' => 30],
        ['day' => '9', 'weight' => 242, 'dfc_factor' => 0.70, 'dfc_optimal' => 35],
        ['day' => '10', 'weight' => 279, 'dfc_factor' => 0.80, 'dfc_optimal' => 40],
        ['day' => '11', 'weight' => 320, 'dfc_factor' => 0.90, 'dfc_optimal' => 45],
        ['day' => '12', 'weight' => 364, 'dfc_factor' => 1.0, 'dfc_optimal' => 50],
        ['day' => '13', 'weight' => 410, 'dfc_factor' => 1.10, 'dfc_optimal' => 55],
        ['day' => '14', 'weight' => 459, 'dfc_factor' => 1.20, 'dfc_optimal' => 60],
        ['day' => '15', 'weight' => 511, 'dfc_factor' => 1.32, 'dfc_optimal' => 66],
        ['day' => '16', 'weight' => 567, 'dfc_factor' => 1.44, 'dfc_optimal' => 72],
        ['day' => '17', 'weight' => 626, 'dfc_factor' => 1.56, 'dfc_optimal' => 78],
        ['day' => '18', 'weight' => 688, 'dfc_factor' => 1.68, 'dfc_optimal' => 84],
        ['day' => '19', 'weight' => 753, 'dfc_factor' => 1.80, 'dfc_optimal' => 90],
        ['day' => '20', 'weight' => 821, 'dfc_factor' => 1.92, 'dfc_optimal' => 96],
        ['day' => '21', 'weight' => 891, 'dfc_factor' => 2.04, 'dfc_optimal' => 102],
        ['day' => '22', 'weight' => 964, 'dfc_factor' => 2.18, 'dfc_optimal' => 109],
        ['day' => '23', 'weight' => 1039, 'dfc_factor' => 2.32, 'dfc_optimal' => 116],
        ['day' => '24', 'weight' => 1115, 'dfc_factor' => 2.46, 'dfc_optimal' => 123],
        ['day' => '25', 'weight' => 1193, 'dfc_factor' => 2.60, 'dfc_optimal' => 130],
        ['day' => '26', 'weight' => 1372, 'dfc_factor' => 2.74, 'dfc_optimal' => 137],
        ['day' => '27', 'weight' => 1353, 'dfc_factor' => 2.88, 'dfc_optimal' => 141],
        ['day' => '28', 'weight' => 1436, 'dfc_factor' => 3.02, 'dfc_optimal' => 151],
        ['day' => '29', 'weight' => 1521, 'dfc_factor' => 3.16, 'dfc_optimal' => 158],
    ];

    public static function getProgram($day)
    {
        return collect(self::$reference)->where('day', $day)->first();
    }

}
