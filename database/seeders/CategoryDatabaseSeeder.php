<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Điện máy - Điện gia dụng', 'slug' => 'dien-may-dien-gia-dung', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['id' => 2, 'name' => 'Laptop', 'slug' => 'laptop', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['id' => 3, 'name' => 'TV - Màn hình TV', 'slug' => 'tv-man-hinh-tv', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['id' => 4, 'name' => 'Máy ảnh - Máy quay phim', 'slug' => 'may-anh-may-quay-phim', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['id' => 39, 'name' => 'Playstation', 'slug' => 'playstation', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['id' => 40, 'name' => 'Điện thoại', 'slug' => 'dien-thoai', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
        ]);

        DB::table('categories')->insert([
            ['id' => 5, 'name' => 'Tủ lạnh', 'slug' => 'thiet-bi-nha-bep', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 1],
            ['id' => 6, 'name' => 'Máy giặt', 'slug' => 'thiet-bi-nha-bep', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 1],
            ['id' => 7, 'name' => 'Thiết bị nhà bếp', 'slug' => 'thiet-bi-nha-bep', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 1],
            ['id' => 8, 'name' => 'Thiết bị gia đình', 'slug' => 'thiet-bi-gia-dinh', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 1],
            ['id' => 9, 'name' => 'Intel Pentium/Celeron', 'slug' => 'intel-pentium-celeron', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 10, 'name' => 'Intel Core i3', 'slug' => 'intel-core-i3', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 11, 'name' => 'Intel Core i5', 'slug' => 'intel-core-i5', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 12, 'name' => 'Intel Core i7', 'slug' => 'intel-core-i7', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 13, 'name' => 'Intel Core i9', 'slug' => 'intel-core-i9', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 14, 'name' => 'AMD Ryzen 3', 'slug' => 'amd-ryzen-3', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 15, 'name' => 'AMD Ryzen 5', 'slug' => 'amd-ryzen-5', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 17, 'name' => 'AMD Ryzen 7', 'slug' => 'amd-ryzen-7', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 2],
            ['id' => 18, 'name' => 'Smart TV', 'slug' => 'smart-tv', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 19, 'name' => 'Internet TV', 'slug' => 'internet-tv', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 20, 'name' => 'Android TV', 'slug' => 'android-tv', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 21, 'name' => 'Box TV', 'slug' => 'box-tv', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 22, 'name' => 'TV LED', 'slug' => 'tv-led', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 23, 'name' => 'TV OLED', 'slug' => 'tv-oled', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 24, 'name' => 'Máy ảnh', 'slug' => 'may-anh', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 3],
            ['id' => 25, 'name' => 'Máy quay phim', 'slug' => 'may-quay-phim', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 4],
            ['id' => 26, 'name' => 'Camera hành trình', 'slug' => 'camera-hanh-trinh', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 4],
        ]);

        DB::table('categories')->insert([
            ['id' => 27, 'name' => 'Tủ lạnh Inverter', 'slug' => 'tu-lanh-inverter', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 5],
            ['id' => 28, 'name' => 'Tủ lạnh Side-by-Side', 'slug' => 'tu-lanh-side-by-side', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 5],
            ['id' => 29, 'name' => 'Tủ lạnh mini', 'slug' => 'tu-lanh-mini', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 5],
            ['id' => 30, 'name' => 'Máy giặt Inverter', 'slug' => 'may-giat-inverter', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 6],
            ['id' => 31, 'name' => 'Máy giặt cửa trên', 'slug' => 'may-giat-cua-tren', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 6],
            ['id' => 32, 'name' => 'Máy giặt cửa dưới', 'slug' => 'may-giat-cua-duoi', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 6],
            ['id' => 33, 'name' => 'Bình đun siêu tốc', 'slug' => 'binh-dun-sieu-toc', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 7],
            ['id' => 34, 'name' => 'Nồi cơm điện', 'slug' => 'noi-com-dien', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 7],
            ['id' => 35, 'name' => 'Lò vi sóng', 'slug' => 'lo-vi-song', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 7],
            ['id' => 36, 'name' => 'Máy lọc không khí', 'slug' => 'may-loc-khong-khi', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 8],
            ['id' => 37, 'name' => 'Máy lọc nước', 'slug' => 'may-loc-nuoc', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 8],
            ['id' => 38, 'name' => 'Bàn ủi', 'slug' => 'ban-ui', 'created_at' => new DateTime(), 'updated_at' => new DateTime(), 'parent_id' => 8],
        ]);
    }
}
