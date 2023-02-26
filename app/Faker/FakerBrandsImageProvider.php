<?php

declare(strict_types=1);

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FakerBrandsImageProvider extends Base
{
    public function lorem(string $dir = 'storage/uploads/brands'): string
    {
        $name = $dir.'/'.Str::random(6).'.jpg';
        Storage::put(
            $name,
            file_get_contents('https://loremflickr.com/700/700/car')
        );

        return $name;
    }
}
