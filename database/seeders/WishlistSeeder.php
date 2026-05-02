<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_wishlist' => $i,
                'id_users' => $i,
                'id_produk' => 11 - $i,
            ];
        }

        DB::table('wishlists')->insert($rows);
    }
}
