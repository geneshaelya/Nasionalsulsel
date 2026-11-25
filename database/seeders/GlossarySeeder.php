<?php

namespace Database\Seeders;

use App\Models\GlossaryTerm;
use App\Models\Hero;
use Illuminate\Database\Seeder;

class GlossarySeeder extends Seeder
{
    public function run(): void
    {
        $heroes = Hero::query()->pluck('id', 'slug');

        $terms = [
            [
                'istilah' => 'Siri’ na Pacce',
                'bahasa' => 'Makassar',
                'pelafalan' => 'si-ri na pat-ce',
                'arti' => 'Harga diri, kehormatan, dan martabat (Siri’) yang berpadu dengan empati solidaritas mendalam terhadap penderitaan sesama (Pacce).',
                'konteks_sejarah' => 'Nilai filosofis utama yang menggerakkan laskar perjuangan di Gowa, Takalar, dan Makassar saat melawan monopoli VOC dan tentara pendudukan NICA.',
                'hero_slug' => 'sultan-hasanuddin',
            ],
            [
                'istilah' => 'Sombaya ri Gowa',
                'bahasa' => 'Makassar',
                'pelafalan' => 'som-ba-ya ri go-wa',
                'arti' => 'Gelar kedaulatan tertinggi bagi Raja/Sultan Kesultanan Gowa yang dihormati sebagai pemersatu dan pelindung rakyat.',
                'konteks_sejarah' => 'Disandang oleh Raja Gowa ke-16 Sultan Hasanuddin dalam memimpin tata kelola kerajaan maritim Somba Opu.',
                'hero_slug' => 'sultan-hasanuddin',
            ],
            [
                'istilah' => 'Tuanta Salamaka',
                'bahasa' => 'Makassar',
                'pelafalan' => 'tu-an-ta sa-la-ma-ka',
                'arti' => 'Guru kami yang membawa keselamatan, keberkahan, dan pencerahan spiritual.',
                'konteks_sejarah' => 'Gelar kehormatan rakyat Gowa dan Sulawesi Selatan bagi ulama sufi dan pejuang anti-kolonial Syekh Yusuf Al-Makassari.',
                'hero_slug' => 'syekh-yusuf',
            ],
            [
                'istilah' => 'Karaeng',
                'bahasa' => 'Makassar',
                'pelafalan' => 'ka-ra-eng',
                'arti' => 'Gelar kebangsawanan tinggi dan pemimpin pemerintahan adat atau distrik pada masyarakat Makassar.',
                'konteks_sejarah' => 'Digunakan antara lain oleh H. Pajonga Daeng Ngalle (Karaeng Polongbangkeng) dan H. Andi Sultan Daeng Radja (Karaeng Gantarang).',
                'hero_slug' => 'pajonga-daeng-ngalle',
            ],
            [
                'istilah' => 'Arung Matoa',
                'bahasa' => 'Bugis',
                'pelafalan' => 'a-rung ma-to-a',
                'arti' => 'Pemimpin tertinggi yang dipilih melalui musyawarah adat Kerajaan Wajo, bermakna raja yang dituakan dan menjunjung hukum adat.',
                'konteks_sejarah' => 'Jabatan yang diemban La Maddukelleng sejak 1736 saat membebaskan Wajo dari tekanan VOC dan sekutunya.',
                'hero_slug' => 'la-maddukelleng',
            ],
            [
                'istilah' => 'Mangkau ri Bone',
                'bahasa' => 'Bugis',
                'pelafalan' => 'mang-kau ri bo-ne',
                'arti' => 'Sebutan bagi Raja tertinggi Kerajaan Bone sebagai pemegang mandat kedaulatan dan adat Pangaderreng.',
                'konteks_sejarah' => 'Disandang oleh H. Andi Mappanyukki (Sultan Ibrahim), Raja Bone ke-32 yang menolak bekerja sama dengan NICA.',
                'hero_slug' => 'andi-mappanyukki',
            ],
            [
                'istilah' => 'Maradeka to Wajoe',
                'bahasa' => 'Bugis',
                'pelafalan' => 'ma-ra-de-ka to wa-jo-e',
                'arti' => 'Orang Wajo adalah manusia merdeka (yang hanya tunduk kepada hukum adat yang disepakati bersama).',
                'konteks_sejarah' => 'Kaidah konstitusional Kerajaan Wajo yang ditegakkan La Maddukelleng dan menjadi spirit kemerdekaan rakyat Bugis.',
                'hero_slug' => 'la-maddukelleng',
            ],
            [
                'istilah' => 'Sipakatau, Sipakalebbi, Sipakainge',
                'bahasa' => 'Bugis',
                'pelafalan' => 'si-pa-ka-tau, si-pa-ka-leb-bi, si-pa-ka-i-nge',
                'arti' => 'Saling memanusiakan, saling memuliakan/menghormati, dan saling mengingatkan dalam kebaikan.',
                'konteks_sejarah' => 'Etika kepemimpinan Bugis-Makassar yang menuntun tata kepemimpinan tokoh-tokoh seperti Andi Mappanyukki dan Jenderal M. Jusuf.',
                'hero_slug' => 'andi-muhammad-jusuf',
            ],
            [
                'istilah' => 'Datu / Pajung Luwu',
                'bahasa' => 'Bugis',
                'pelafalan' => 'da-tu / pa-jung lu-wu',
                'arti' => 'Gelar penguasa tertinggi di Kedatuan Luwu sebagai pemayung dan pelindung seluruh masyarakat Tanah Luwu.',
                'konteks_sejarah' => 'Disandang oleh H. Andi Djemma (Pajung Luwu ke-34) yang memimpin Perlawanan Rakyat Luwu pada 23 Januari 1946.',
                'hero_slug' => 'andi-djemma',
            ],
            [
                'istilah' => 'Opu',
                'bahasa' => 'Bugis',
                'pelafalan' => 'o-pu',
                'arti' => 'Gelar kehormatan bangsawan terpandang di lingkungan Kedatuan Luwu.',
                'konteks_sejarah' => 'Melekat pada pejuang perempuan Opu Daeng Risadju yang rela melepaskan hak istimewa kebangsawanannya demi memimpin pergerakan PSII.',
                'hero_slug' => 'opu-daeng-risadju',
            ],
            [
                'istilah' => 'Buntu Batu',
                'bahasa' => 'Toraja',
                'pelafalan' => 'bun-tu ba-tu',
                'arti' => 'Gunung atau tebing batu yang curam dan kokoh.',
                'konteks_sejarah' => 'Nama salah satu benteng pertahanan utama Panglima Perang Toraja Pong Tiku yang terletak di tebing karang terjal sehingga sulit ditembus tentara Belanda.',
                'hero_slug' => 'pong-tiku',
            ],
            [
                'istilah' => 'Misa’ Kada Dipotuo, Pantan Kada Dipomate',
                'bahasa' => 'Toraja',
                'pelafalan' => 'mi-sa ka-da di-po-tuo, pan-tan ka-da di-po-ma-te',
                'arti' => 'Bersatu dalam satu kata membawa kehidupan, bercerai-berai membawa kehancuran.',
                'konteks_sejarah' => 'Semboyan persatuan masyarakat Toraja yang dipakai untuk menggalang solidaritas para pemimpin adat bersama Pong Tiku.',
                'hero_slug' => 'pong-tiku',
            ],
            [
                'istilah' => 'Maraqdia',
                'bahasa' => 'Mandar',
                'pelafalan' => 'ma-raq-di-a',
                'arti' => 'Gelar raja atau penguasa tertinggi kerajaan dalam struktur adat Persekutuan Pitu Baqbana Binanga (Mandar).',
                'konteks_sejarah' => 'Gelar yang disandang Hj. Andi Depu sebagai Maraqdia Balanipa ke-52 saat mempertahankan Sang Merah Putih dari pasukan penjajah.',
                'hero_slug' => 'hj-andi-depu',
            ],
            [
                'istilah' => 'Baruga',
                'bahasa' => 'Makassar',
                'pelafalan' => 'ba-ru-ga',
                'arti' => 'Balai pertemuan adat atau gedung serbaguna tempat bermusyawarah dan menyelenggarakan upacara resmi.',
                'konteks_sejarah' => 'Diabadikan menjadi Baruga A.P. Pettarani di Universitas Hasanuddin untuk mengenang jasa Gubernur Sulawesi Andi Pangerang Pettarani.',
                'hero_slug' => 'andi-pangerang-pettarani',
            ],
        ];

        foreach ($terms as $term) {
            $heroSlug = $term['hero_slug'];
            unset($term['hero_slug']);

            $term['hero_id'] = $heroSlug ? ($heroes[$heroSlug] ?? null) : null;
            $term['is_published'] = true;

            GlossaryTerm::updateOrCreate(
                ['istilah' => $term['istilah'], 'bahasa' => $term['bahasa']],
                $term
            );
        }
    }
}
