<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

                $news = [
            [
                'title' => 'Pemerintah Rilis Program Baru untuk Percepatan Digitalisasi Sekolah',
                'content' => 'Program ini menargetkan pemerataan perangkat, jaringan internet, dan pelatihan guru agar transformasi digital di sekolah dapat berjalan lebih cepat dan merata.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
                'publisher' => 'Kompas.com',
                'event_date' => Carbon::now()->subDay(),
                'source_url' => 'https://www.kompas.com',
            ],
            [
                'title' => 'Harga Pangan Stabil di Sejumlah Pasar Tradisional Menjelang Akhir Pekan',
                'content' => 'Sejumlah pedagang melaporkan stok bahan pokok masih aman, sementara pemerintah daerah memperkuat pemantauan agar harga tetap terkendali.',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80',
                'publisher' => 'Detik.com',
                'event_date' => Carbon::now()->subDays(2),
                'source_url' => 'https://www.detik.com',
            ],
            [
                'title' => 'Komunitas Kreatif Kota Besar Dorong Ekonomi Lokal Lewat Festival UMKM',
                'content' => 'Festival tahunan ini mempertemukan pelaku usaha mikro, desainer muda, dan investor untuk membuka akses pasar yang lebih luas.',
                'image' => 'https://images.unsplash.com/photo-1515169067868-5387ec356754?auto=format&fit=crop&w=1200&q=80',
                'publisher' => 'Kumparan',
                'event_date' => Carbon::now()->subDays(3),
                'source_url' => 'https://www.kumparan.com',
            ],
            [
                'title' => 'BMKG Ingatkan Potensi Hujan Lebat di Sejumlah Wilayah Pada Sore Hari',
                'content' => 'Warga diimbau memperhatikan kondisi cuaca, terutama bagi pengendara dan masyarakat yang beraktivitas di area rawan genangan.',
                'image' => 'https://images.unsplash.com/photo-1500673922987-e212871fec22?auto=format&fit=crop&w=1200&q=80',
                'publisher' => 'CNN Indonesia',
                'event_date' => Carbon::now()->subDays(4),
                'source_url' => 'https://www.cnnindonesia.com',
            ],
        ];

        foreach ($news as $item) {
            Post::updateOrCreate([
                'title' => $item['title'],
            ], array_merge($item, [
                'published' => 'yes',
            ]));
        }
    }
}
