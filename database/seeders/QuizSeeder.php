<?php

namespace Database\Seeders;

use App\Models\Hero;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kuis Keseluruhan (ditampilkan sebelum kuis individual tiap pahlawan)
        $overallQuiz = Quiz::updateOrCreate(
            ['slug' => 'kuis-umum-pahlawan-sulsel'],
            [
                'hero_id' => null,
                'judul' => 'Kuis Umum Pahlawan Nasional Sulawesi Selatan',
                'deskripsi' => 'Uji pengetahuan menyeluruh tentang sejarah ke-14 Pahlawan Nasional asal Sulawesi Selatan, dari era kesultanan maritim hingga masa Revolusi Kemerdekaan dan penetapan terbaru 2026.',
                'durasi_menit' => 15,
                'passing_score' => 70,
                'is_active' => true,
            ]
        );

        $overallQuestions = [
            [
                'pertanyaan' => 'Siapakah Raja Gowa ke-16 yang dijuluki Belanda sebagai "Ayam Jantan dari Timur" (De Haantjes van het Oosten)?',
                'opsi' => ['Sultan Hasanuddin', 'Syekh Yusuf Al-Makassari', 'La Maddukelleng', 'Andi Mappanyukki'],
                'jawaban_benar' => 0,
                'penjelasan' => 'Sultan Hasanuddin (I Mallombasi Daeng Mattawang) memimpin perlawanan maritim Kesultanan Gowa melawan monopoli VOC.',
            ],
            [
                'pertanyaan' => 'Siapakah Pahlawan Nasional ke-14 asal Sulawesi Selatan yang dikukuhkan melalui Keppres No. 93/TK/Tahun 2026?',
                'opsi' => ['Andi Pangerang Pettarani', 'Jenderal TNI (Purn.) Andi Muhammad Jusuf Amir', 'Lanto Daeng Pasewang', 'Andi Sultan Daeng Radja'],
                'jawaban_benar' => 1,
                'penjelasan' => 'Andi Muhammad Jusuf Amir (M. Jusuf) resmi dianugerahi gelar Pahlawan Nasional pada 10 November 2026.',
            ],
            [
                'pertanyaan' => 'Organisasi gerilya Laskar Pemberontak Rakyat Indonesia Sulawesi (LAPRIS) pada 17 Juli 1946 didirikan oleh Ranggong Daeng Romo bersama siapa?',
                'opsi' => ['Pong Tiku', 'Robert Wolter Mongisidi', 'La Maddukelleng', 'Sultan Hasanuddin'],
                'jawaban_benar' => 1,
                'penjelasan' => 'Ranggong Daeng Romo dan Robert Wolter Mongisidi bersama para pemuda membentuk LAPRIS di Polongbangkeng.',
            ],
            [
                'pertanyaan' => 'Di negara mana Pahlawan Nasional Syekh Yusuf Al-Makassari diasingkan hingga wafat dan turut dihormati sebagai pahlawan kemanusiaan?',
                'opsi' => ['Australia', 'Filipina', 'Afrika Selatan', 'Mesir'],
                'jawaban_benar' => 2,
                'penjelasan' => 'Syekh Yusuf diasingkan ke Sri Lanka lalu ke Cape Town, Afrika Selatan; kawasan makam awalnya dinamai kota Macassar.',
            ],
            [
                'pertanyaan' => 'Pahlawan Nasional asal Tana Toraja yang membangun tujuh benteng batu strategis di puncak pegunungan melawan pasukan Belanda adalah...',
                'opsi' => ['Pong Tiku (Ne’ Baso)', 'Andi Djemma', 'Opu Daeng Risadju', 'Pajonga Daeng Ngalle'],
                'jawaban_benar' => 0,
                'penjelasan' => 'Pong Tiku atau Ne’ Baso adalah Panglima Perang Tana Toraja yang memimpin gerilya benteng batu hingga 1907.',
            ],
            [
                'pertanyaan' => 'Pada 15 Oktober 1945, H. Andi Mappanyukki memimpin pertemuan bersejarah para raja Sulawesi Selatan untuk mendukung RI di mana?',
                'opsi' => ['Palopo', 'Jongaya, Makassar', 'Sengkang', 'Tinambung'],
                'jawaban_benar' => 1,
                'penjelasan' => 'Deklarasi Jongaya dipimpin Raja Bone ke-32 Andi Mappanyukki untuk menyatakan dukungan penuh raja-raja Sulsel kepada NKRI.',
            ],
            [
                'pertanyaan' => 'Siapakah tokoh Sulsel yang hadir dalam Kongres Sumpah Pemuda 1928 sekaligus menjadi anggota PPKI tahun 1945?',
                'opsi' => ['H. Andi Sultan Daeng Radja', 'Andi Abdullah Bau Massepe', 'Ranggong Daeng Romo', 'La Maddukelleng'],
                'jawaban_benar' => 0,
                'penjelasan' => 'Andi Sultan Daeng Radja (Karaeng Gantarang, Bulukumba) merupakan wakil pergerakan Sulawesi di Kongres Pemuda II 1928 dan PPKI 1945.',
            ],
            [
                'pertanyaan' => 'Kedua srikandi pejuang asal Tanah Luwu dan Tanah Mandar yang mendapat gelar Pahlawan Nasional adalah...',
                'opsi' => ['Emmy Saelan dan Ibu Agung', 'Opu Daeng Risadju dan Hj. Andi Depu', 'Ranggong dan Pattarani', 'Andi Djemma dan Opu Daeng Risadju'],
                'jawaban_benar' => 1,
                'penjelasan' => 'Opu Daeng Risadju (Luwu, Keppres 2006) dan Hj. Andi Depu (Mandar, Keppres 2018) adalah dua pahlawan nasional perempuan Sulsel.',
            ],
            [
                'pertanyaan' => 'Instansi daerah yang bertugas meneliti dan mengkaji kelayakan calon Pahlawan Nasional di tingkat provinsi sebelum diajukan ke Kementerian Sosial RI disebut...',
                'opsi' => ['TP2GD', 'LAPRIS', 'BAPEPAM', 'OSVIA'],
                'jawaban_benar' => 0,
                'penjelasan' => 'TP2GD adalah Tim Peneliti dan Pengkaji Gelar Daerah yang sekretariatnya berada di Dinas Sosial Provinsi.',
            ],
            [
                'pertanyaan' => 'Siapakah Datu Luwu ke-34 yang memimpin Perlawanan Semesta Rakyat Luwu melawan NICA pada 23 Januari 1946?',
                'opsi' => ['La Maddukelleng', 'H. Andi Djemma', 'Andi Pangerang Pettarani', 'Pajonga Daeng Ngalle'],
                'jawaban_benar' => 1,
                'penjelasan' => 'H. Andi Djemma menyatakan Kedatuan Luwu bagian sah RI dan memimpin perlawanan rakyat di Palopo pada Januari 1946.',
            ],
        ];

        $this->syncQuestions($overallQuiz, $overallQuestions);

        // 2. Kuis Individual untuk tiap pahlawan
        $perHeroQuestions = [
            'sultan-hasanuddin' => [
                ['pertanyaan' => 'Siapakah nama asli Sultan Hasanuddin sebelum dinobatkan menjadi Raja Gowa ke-16?', 'opsi' => ['I Mallombasi Muhammad Bakir Daeng Mattawang', 'I Makkulau Daeng Serang', 'Famajjah Daeng Risadju', 'Ne’ Baso'], 'jawaban_benar' => 0, 'penjelasan' => 'Nama lahir beliau adalah I Mallombasi Muhammad Bakir Daeng Mattawang Karaeng Bonto Mangape.'],
                ['pertanyaan' => 'Benteng utama Kesultanan Gowa yang menjadi pusat pertahanan maritim pada Perang Makassar adalah...', 'opsi' => ['Benteng Duurstede', 'Benteng Somba Opu', 'Benteng Buntu Batu', 'Benteng Tosora'], 'jawaban_benar' => 1, 'penjelasan' => 'Benteng Somba Opu menjadi pusat niaga internasional dan pertahanan utama Gowa sebelum 1669.'],
                ['pertanyaan' => 'Pada tahun berapakah Sultan Hasanuddin resmi ditetapkan sebagai Pahlawan Nasional?', 'opsi' => ['1973', '1995', '2004', '2018'], 'jawaban_benar' => 0, 'penjelasan' => 'Sultan Hasanuddin ditetapkan melalui Keppres No. 087/TK/1973 tanggal 6 November 1973.'],
            ],
            'syekh-yusuf' => [
                ['pertanyaan' => 'Apakah gelar kehormatan masyarakat Gowa bagi Syekh Yusuf Tajul Khalwati?', 'opsi' => ['Tuanta Salamaka ri Gowa', 'Karaeng Gantarang', 'Arung Matoa', 'Ayam Jantan dari Timur'], 'jawaban_benar' => 0, 'penjelasan' => 'Tuanta Salamaka ri Gowa bermakna "Guru kami yang membawa keselamatan dari Gowa".'],
                ['pertanyaan' => 'Kesultanan di Pulau Jawa tempat Syekh Yusuf menjadi mufti dan menantu raja dalam perang melawan VOC adalah...', 'opsi' => ['Kesultanan Mataram', 'Kesultanan Banten', 'Kesultanan Cirebon', 'Kesultanan Demak'], 'jawaban_benar' => 1, 'penjelasan' => 'Syekh Yusuf mendampingi Sultan Ageng Tirtayasa di Kesultanan Banten melawan VOC.'],
                ['pertanyaan' => 'Apa nama wilayah di Cape Town, Afrika Selatan yang dinamai berdasarkan asal-usul Syekh Yusuf?', 'opsi' => ['Makassar Baru', 'Macassar', 'Katangka Selatan', 'Gowa Town'], 'jawaban_benar' => 1, 'penjelasan' => 'Permukiman sekitar Zandvliet dekat Cape Town hingga kini bernama Macassar.'],
            ],
            'la-maddukelleng' => [
                ['pertanyaan' => 'La Maddukelleng memegang jabatan tertinggi sebagai pemimpin Kerajaan Wajo dengan gelar...', 'opsi' => ['Datu Luwu', 'Arung Matoa Wajo', 'Mangkau ri Bone', 'Maraqdia'], 'jawaban_benar' => 1, 'penjelasan' => 'Beliau terpilih sebagai Arung Matoa Wajo (1736–1754) sekaligus sebelumnya bergelar Sultan Paser.'],
                ['pertanyaan' => 'Sebelum pulang membebaskan Wajo dari blokade VOC, di wilayah Kalimantan mana La Maddukelleng menjadi pemimpin maritim?', 'opsi' => ['Kesultanan Paser', 'Kesultanan Banjar', 'Pontianak', 'Sambas'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau membangun kekuatan armada laut dan dinobatkan sebagai Sultan di Paser, Kalimantan Timur.'],
                ['pertanyaan' => 'Apa makna semboyan Wajo yang ditegakkan La Maddukelleng: "Maradeka to Wajoe, ade’nami napopuang"?', 'opsi' => ['Rakyat Wajo tunduk pada kekuasaan asing', 'Orang Wajo merdeka, hanya hukum adat yang menjadi tuannya', 'Pelabuhan hanya dibuka untuk sekutu', 'Raja tidak terikat hukum'], 'jawaban_benar' => 1, 'penjelasan' => 'Falsafah konstitusional Bugis ini menegaskan supremasi hukum adat dan kemerdekaan rakyat Wajo.'],
            ],
            'pong-tiku' => [
                ['pertanyaan' => 'Nama kecil Pahlawan Nasional Pong Tiku dari Pangala’, Tana Toraja adalah...', 'opsi' => ['Ne’ Baso', 'I Mallombasi', 'Famajjah', 'Bau Massepe'], 'jawaban_benar' => 0, 'penjelasan' => 'Pong Tiku lahir dengan nama Ne’ Baso pada tahun 1846.'],
                ['pertanyaan' => 'Strategi khas pasukan Pong Tiku dalam menahan serangan artileri Belanda di Toraja memanfaatkan...', 'opsi' => ['Armada perahu pinisi', 'Jaringan tujuh benteng batu di tebing pegunungan', 'Pertempuran kapal uap', 'Parit di pesisir pantai'], 'jawaban_benar' => 1, 'penjelasan' => 'Benteng-benteng alam di puncak bukit batu seperti Buntu Batu dan Alla’ menyulitkan pasukan marsose Belanda.'],
                ['pertanyaan' => 'Infrastruktur transportasi di Tana Toraja yang mengabadikan nama beliau adalah...', 'opsi' => ['Pelabuhan Rantepao', 'Bandar Udara Pongtiku', 'Stasiun Makale', 'Jembatan Sa’dan'], 'jawaban_benar' => 1, 'penjelasan' => 'Nama beliau diabadikan sebagai nama Bandar Udara Pongtiku di Rantetayo.'],
            ],
            'andi-mappanyukki' => [
                ['pertanyaan' => 'Gelar Sultan yang disandang H. Andi Mappanyukki saat menjabat Raja Bone ke-32 adalah...', 'opsi' => ['Sultan Hasanuddin', 'Sultan Ibrahim', 'Sultan Alauddin', 'Sultan Malikussaid'], 'jawaban_benar' => 1, 'penjelasan' => 'Beliau naik takhta pada 1931 dengan gelar Sultan Ibrahim.'],
                ['pertanyaan' => 'Di manakah H. Andi Mappanyukki memimpin rapat para raja Sulsel pada 15 Oktober 1945 yang mendukung Republik Indonesia?', 'opsi' => ['Jongaya, Makassar', 'Sengkang', 'Benteng Somba Opu', 'Palopo'], 'jawaban_benar' => 0, 'penjelasan' => 'Pertemuan Jongaya menjadi penegasan resmi dukungan raja-raja Sulawesi Selatan bagi kemerdekaan RI.'],
                ['pertanyaan' => 'Siapakah putra Andi Mappanyukki yang juga ditetapkan sebagai Pahlawan Nasional pada tahun 2005?', 'opsi' => ['Robert Wolter Mongisidi', 'Andi Abdullah Bau Massepe', 'Ranggong Daeng Romo', 'Pajonga Daeng Ngalle'], 'jawaban_benar' => 1, 'penjelasan' => 'Andi Abdullah Bau Massepe adalah putra Andi Mappanyukki sekaligus Panglima TRI Divisi Hasanuddin.'],
            ],
            'andi-djemma' => [
                ['pertanyaan' => 'Andi Djemma merupakan Datu atau Pajung dari kerajaan tertua di Sulawesi Selatan, yakni...', 'opsi' => ['Kerajaan Gowa', 'Kedatuan Luwu', 'Kerajaan Bone', 'Kerajaan Wajo'], 'jawaban_benar' => 1, 'penjelasan' => 'Andi Djemma adalah Datu / Pajung Luwu ke-34 yang memproklamasikan dukungan Luwu kepada RI.'],
                ['pertanyaan' => 'Tanggal berapa peristiwa Perlawanan Semesta Rakyat Luwu yang dipimpin Andi Djemma terjadi di Palopo?', 'opsi' => ['17 Agustus 1945', '23 Januari 1946', '5 September 1949', '10 November 1950'], 'jawaban_benar' => 1, 'penjelasan' => 'Tanggal 23 Januari 1946 diperingati hingga kini sebagai Hari Perjuangan Rakyat Luwu (HPRL).'],
                ['pertanyaan' => 'Setelah tertawan di Palopo, ke pulau mana saja Andi Djemma pernah diasingkan oleh Belanda hingga 1950?', 'opsi' => ['Morotai dan Ternate', 'Bangka dan Belitung', 'Banda Neira dan Digul', 'Flores dan Timor'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau ditahan di Makassar lalu diasingkan ke Pulau Morotai dan Ternate.'],
            ],
            'ranggong-daeng-romo' => [
                ['pertanyaan' => 'Nama laskar perjuangan di Polongbangkeng yang dipimpin Ranggong Daeng Romo adalah...', 'opsi' => ['Laskar Kris Muda', 'Laskar Lipan Bajeng', 'Barisan Srikandi', 'TKR Laut'], 'jawaban_benar' => 1, 'penjelasan' => 'Gerakan Muda Bajeng bertransformasi menjadi Laskar Lipan Bajeng yang ditakuti konvoi NICA.'],
                ['pertanyaan' => 'Pada 17 Juli 1946, 19 organisasi kelaskaran pemuda Sulawesi Selatan disatukan menjadi...', 'opsi' => ['LAPRIS', 'BPUPKI', 'KNIP', 'TKR Barat'], 'jawaban_benar' => 0, 'penjelasan' => 'LAPRIS (Laskar Pemberontak Rakyat Indonesia Sulawesi) dipimpin Ranggong Daeng Romo sebagai Panglima Besar.'],
                ['pertanyaan' => 'Di lokasi manakah Ranggong Daeng Romo gugur dalam pertempuran melawan pasukan Belanda pada 27 Februari 1947?', 'opsi' => ['Langgese, Takalar', 'Rantepao', 'Watampone', 'Tinambung'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau gugur di Langgese, Takalar pada usia 32 tahun setelah dikepung pasukan Belanda.'],
            ],
            'andi-abdullah-bau-massepe' => [
                ['pertanyaan' => 'Wilayah utama perjuangan Andi Abdullah Bau Massepe (Datu Suppa) berada di kawasan...', 'opsi' => ['Ajatappareng (Parepare, Suppa, Pinrang, Sidrap)', 'Kepulauan Selayar', 'Tana Toraja', 'Sinjai'], 'jawaban_benar' => 0, 'penjelasan' => 'Sebagai Datu Suppa dan Panglima TRI Divisi Hasanuddin, beliau memimpin perlawanan di kawasan Ajatappareng.'],
                ['pertanyaan' => 'Sikap yang ditunjukkan Andi Abdullah Bau Massepe ketika ditawari jabatan tinggi oleh Belanda asalkan mengakui NICA adalah...', 'opsi' => ['Menerima jabatan sementara', 'Menolak tegas dan memilih menghadapi regu tembak', 'Mengungsi ke luar negeri', 'Membubarkan pasukannya'], 'jawaban_benar' => 1, 'penjelasan' => 'Beliau menolak mengkhianati Republik dan gugur ditembak mati pada 2 Februari 1947 di Parepare.'],
                ['pertanyaan' => 'Di kota manakah nama Andi Abdullah Bau Massepe diabadikan pada jalan utama dan kawasan monumen perjuangan?', 'opsi' => ['Kota Parepare', 'Kota Palopo', 'Kota Watampone', 'Kota Bulukumba'], 'jawaban_benar' => 0, 'penjelasan' => 'Jalan dan monumen Bau Massepe merupakan penanda sejarah utama di Kota Parepare.'],
            ],
            'wr-mongonsidi' => [
                ['pertanyaan' => 'Walaupun lahir di Manado, pusat perlawanan gerilya Robert Wolter Mongisidi berlangsung di...', 'opsi' => ['Makassar dan sekitarnya', 'Surabaya', 'Bandung', 'Palembang'], 'jawaban_benar' => 0, 'penjelasan' => 'Mongisidi memimpin aksi gerilya kota di Makassar bersama LAPRIS.'],
                ['pertanyaan' => 'Apa kalimat wasiat terkenal yang ditulis Wolter Mongisidi sebelum menghadapi regu tembak pada 5 September 1949?', 'opsi' => ['Merdeka atau mati', 'Setia hingga terakhir di dalam keyakinan', 'Sekali berarti sudah itu mati', 'Pantang mundur'], 'jawaban_benar' => 1, 'penjelasan' => 'Wasiat "Setia hingga terakhir di dalam keyakinan" ditulis menjelang eksekusi di usia 24 tahun.'],
                ['pertanyaan' => 'Permintaan khusus Wolter Mongisidi saat hendak dieksekusi oleh regu tembak Belanda adalah...', 'opsi' => ['Meminta pengampunan grasi', 'Meminta agar matanya tidak ditutup', 'Meminta penundaan satu tahun', 'Meminta dibebaskan dengan jaminan'], 'jawaban_benar' => 1, 'penjelasan' => 'Ia menolak grasi maupun penutup mata dan menghadapkan dada dengan tegak.'],
            ],
            'pajonga-daeng-ngalle' => [
                ['pertanyaan' => 'Apa jabatan adat dan pemerintahan H. Pajonga Daeng Ngalle yang menjadikannya penggerak perjuangan di Takalar?', 'opsi' => ['Karaeng Polongbangkeng ke-12', 'Datu Luwu', 'Mangkau ri Bone', 'Sombaya ri Gowa'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau menjabat sebagai Karaeng Polongbangkeng sejak tahun 1934.'],
                ['pertanyaan' => 'Status apa yang dideklarasikan H. Pajonga Daeng Ngalle bagi wilayah Polongbangkeng pada masa Revolusi?', 'opsi' => ['Wilayah de facto Republik Indonesia', 'Bagian dari Negara Indonesia Timur', 'Zona netral dagang', 'Daerah otonom Belanda'], 'jawaban_benar' => 0, 'penjelasan' => 'Polongbangkeng ditetapkan sebagai daerah de facto RI dan basis perlindungan pasukan LAPRIS.'],
                ['pertanyaan' => 'Fasilitas kesehatan daerah yang memakai nama H. Padjonga Dg. Ngalle berada di kabupaten mana?', 'opsi' => ['Kabupaten Takalar', 'Kabupaten Sinjai', 'Kabupaten Barru', 'Kabupaten Enrekang'], 'jawaban_benar' => 0, 'penjelasan' => 'Nama beliau diabadikan menjadi nama RSUD H. Padjonga Dg. Ngalle Kabupaten Takalar.'],
            ],
            'andi-sultan-daeng-radja' => [
                ['pertanyaan' => 'Andi Sultan Daeng Radja berasal dari keluarga bangsawan dan menjadi Karaeng Gantarang di daerah...', 'opsi' => ['Bulukumba', 'Bone', 'Sidrap', 'Luwu'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau lahir di Matekko, Gantarang, Kabupaten Bulukumba pada 20 Mei 1894.'],
                ['pertanyaan' => 'Peristiwa nasional bersejarah tahun 1928 yang dihadiri langsung oleh Andi Sultan Daeng Radja adalah...', 'opsi' => ['Kongres Sumpah Pemuda (Kongres Pemuda II)', 'Konferensi Meja Bundar', 'Perundingan Linggarjati', 'Kongres Ekonomi'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau merupakan salah satu wakil pergerakan pemuda Sulawesi pada Kongres Sumpah Pemuda 1928.'],
                ['pertanyaan' => 'Pada Agustus 1945, Andi Sultan Daeng Radja dipercaya menjadi wakil Sulawesi dalam badan persiapan kemerdekaan bernama...', 'opsi' => ['PPKI', 'Volksraad', 'BFO', 'NICA'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau menjadi anggota Panitia Persiapan Kemerdekaan Indonesia (PPKI) bersama Dr. Sam Ratulangi.'],
            ],
            'opu-daeng-risadju' => [
                ['pertanyaan' => 'Nama kecil Pahlawan Nasional perempuan Opu Daeng Risadju adalah...', 'opsi' => ['Famajjah', 'Salma', 'I Sabbe', 'We Tenriolle'], 'jawaban_benar' => 0, 'penjelasan' => 'Opu Daeng Risadju adalah gelar kebangsawanan Luwu; nama lahirnya adalah Famajjah.'],
                ['pertanyaan' => 'Organisasi pergerakan nasional yang dipimpin Opu Daeng Risadju cabang Palopo sejak tahun 1930 adalah...', 'opsi' => ['PSII (Partai Sarekat Islam Indonesia)', 'Budi Utomo', 'Indische Partij', 'Jong Java'], 'jawaban_benar' => 0, 'penjelasan' => 'Ia merintis dan mengetuai PSII Palopo guna membangkitkan kesadaran kemerdekaan rakyat Luwu.'],
                ['pertanyaan' => 'Akibat penyiksaan tentara NICA saat ditangkap di usia lanjut (66 tahun), Opu Daeng Risadju mengalami...', 'opsi' => ['Gangguan pendengaran permanen (tuli)', 'Pindah keluar negeri', 'Menyerahkan gelar kepada Belanda', 'Berhenti mendukung kemerdekaan'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau disiksa dan dipaksa berjalan kaki puluhan kilometer hingga mengalami ketulian seumur hidup.'],
            ],
            'hj-andi-depu' => [
                ['pertanyaan' => 'Hj. Andi Depu merupakan Maraqdia (penguasa) kerajaan mana di Tanah Mandar?', 'opsi' => ['Kerajaan Balanipa', 'Kerajaan Gowa', 'Kerajaan Bone', 'Kerajaan Soppeng'], 'jawaban_benar' => 0, 'penjelasan' => 'Hj. Andi Depu adalah Maraqdia Balanipa ke-52 yang gigih mempertahankan Merah Putih.'],
                ['pertanyaan' => 'Organisasi laskar perlawanan yang dibentuk dan dipimpin Hj. Andi Depu bernama...', 'opsi' => ['Kris Muda Mandar', 'Laskar Lipan Bajeng', 'Tentara Pelajar', 'Barisan Banteng'], 'jawaban_benar' => 0, 'penjelasan' => 'Kris Muda Mandar menjadi garda depan perlawanan rakyat di Tinambung melawan tentara pendudukan.'],
                ['pertanyaan' => 'Sebutan kehormatan yang diberikan Presiden Soekarno kepada Hj. Andi Depu adalah...', 'opsi' => ['Ibu Agung', 'Srikandi Timur', 'Ratu Maritim', 'Bunda Bangsa'], 'jawaban_benar' => 0, 'penjelasan' => 'Presiden Soekarno menganugerahkan sebutan "Ibu Agung" atas keteguhannya mengibarkan Merah Putih.'],
            ],
            'andi-muhammad-jusuf' => [
                ['pertanyaan' => 'Di kabupaten manakah Jenderal TNI (Purn.) Andi Muhammad Jusuf Amir lahir pada 23 Juni 1928?', 'opsi' => ['Kajuara, Kabupaten Bone', 'Rantepao, Toraja Utara', 'Sungguminasa, Gowa', 'Palopo, Luwu'], 'jawaban_benar' => 0, 'penjelasan' => 'M. Jusuf lahir di Kajuara, Kabupaten Bone dan mengawali perjuangan sejak masa revolusi di Sulsel.'],
                ['pertanyaan' => 'Program pembangunan pedesaan oleh TNI yang dicetuskan Jenderal M. Jusuf saat menjabat Panglima ABRI/Menhankam adalah...', 'opsi' => ['ABRI Masuk Desa (AMD / TMMD)', 'Transmigrasi Nasional', 'Wajib Belajar 6 Tahun', 'Pelita Maritim'], 'jawaban_benar' => 0, 'penjelasan' => 'Program ABRI Masuk Desa (AMD) mendekatkan prajurit kepada rakyat melalui pembangunan infrastruktur desa.'],
                ['pertanyaan' => 'Pada tahun berapakah Jenderal M. Jusuf resmi ditetapkan sebagai Pahlawan Nasional asal Sulsel ke-14?', 'opsi' => ['2018', '2022', '2026', '2006'], 'jawaban_benar' => 2, 'penjelasan' => 'Ditetapkan melalui Keppres No. 93/TK/Tahun 2026 pada 10 November 2026.'],
            ],
            'emmy-saelan' => [
                ['pertanyaan' => 'Sebelum bergabung sebagai gerilyawati LAPRIS, profesi kemanusiaan yang dijalankan Emmy Saelan di Makassar adalah...', 'opsi' => ['Perawat di RS Stella Maris', 'Jurnalis', 'Hakim Adat', 'Pedagang Rempah'], 'jawaban_benar' => 0, 'penjelasan' => 'Emmy Saelan adalah perawat yang mengorganisir aksi solidaritas tenaga medis menentang NICA.'],
                ['pertanyaan' => 'Di mana lokasi gugurnya Emmy Saelan pada 23 Januari 1947 saat melindungi rekan seperjuangannya?', 'opsi' => ['Kassi-Kassi, Makassar', 'Palopo', 'Parepare', 'Sengkang'], 'jawaban_benar' => 0, 'penjelasan' => 'Emmy Saelan gugur di Kassi-Kassi ketika terkepung pasukan Belanda dan kini dimakamkan di TMP Panaikang.'],
                ['pertanyaan' => 'Apakah status kepahlawanan Emmy Saelan dalam direktori sejarah Sulawesi Selatan?', 'opsi' => ['Pahlawan Daerah Sulawesi Selatan', 'Pahlawan Revolusi 1965', 'Raja Kerajaan Gowa', 'Gubernur Sulawesi'], 'jawaban_benar' => 0, 'penjelasan' => 'Emmy Saelan adalah pahlawan terkenal daerah Sulawesi Selatan yang namanya diabadikan sebagai jalan utama Makassar.'],
            ],
            'andi-pangerang-pettarani' => [
                ['pertanyaan' => 'Andi Pangerang Pettarani menjabat sebagai Gubernur Sulawesi pada periode tahun...', 'opsi' => ['1956–1960', '1945–1949', '1978–1983', '1966–1970'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau menjabat Gubernur Sulawesi 1956–1960 menggantikan Lanto Daeng Pasewang.'],
                ['pertanyaan' => 'Perguruan tinggi negeri terkemuka di Indonesia Timur yang mendapat dukungan gedung dan fasilitas pendirian dari A.P. Pettarani adalah...', 'opsi' => ['Universitas Hasanuddin (Unhas)', 'Institut Teknologi Bandung', 'Universitas Udayana', 'Universitas Sam Ratulangi'], 'jawaban_benar' => 0, 'penjelasan' => 'Jasa beliau dikenang abadi pada gedung Baruga A.P. Pettarani di Universitas Hasanuddin.'],
                ['pertanyaan' => 'Siapakah ayahanda Andi Pangerang Pettarani?', 'opsi' => ['H. Andi Mappanyukki', 'Sultan Hasanuddin', 'Pong Tiku', 'Lanto Daeng Pasewang'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau adalah putra dari Raja Bone ke-32 H. Andi Mappanyukki.'],
            ],
            'lanto-daeng-pasewang' => [
                ['pertanyaan' => 'Jabatan pemerintahan yang diemban Lanto Daeng Pasewang pada periode 1953–1956 adalah...', 'opsi' => ['Gubernur Provinsi Sulawesi', 'Bupati Toraja', 'Panglima ABRI', 'Ketua PPKI'], 'jawaban_benar' => 0, 'penjelasan' => 'Beliau menjabat Gubernur Sulawesi sebelum diteruskan oleh Andi Pangerang Pettarani.'],
                ['pertanyaan' => 'Status pengkajian tokoh Lanto Daeng Pasewang saat ini di portal Dinas Sosial Sulawesi Selatan adalah...', 'opsi' => ['Calon Pahlawan Nasional (Kajian TP2GD)', 'Raja Kerajaan Bone', 'Tokoh Kesultanan Banten', 'Anggota VOC'], 'jawaban_benar' => 0, 'penjelasan' => 'Profil dan berkas kesejarahan beliau masuk dalam kajian pengusulan gelar TP2GD.'],
                ['pertanyaan' => 'Di kota manakah nama Lanto Daeng Pasewang diabadikan menjadi nama jalan utama serta dimakamkan di TMP Panaikang?', 'opsi' => ['Kota Makassar', 'Kota Manado', 'Kota Palu', 'Kota Kendari'], 'jawaban_benar' => 0, 'penjelasan' => 'Jalan Lanto Daeng Pasewang terletak di kawasan pusat Kota Makassar.'],
            ],
        ];

        $heroes = Hero::query()->get();
        foreach ($heroes as $hero) {
            $quiz = Quiz::updateOrCreate(
                ['slug' => 'kuis-'.$hero->slug],
                [
                    'hero_id' => $hero->id,
                    'judul' => 'Kuis Biografi: '.$hero->nama,
                    'deskripsi' => 'Uji pemahamanmu mengenai perjalanan hidup dan perjuangan '.$hero->nama.'.',
                    'durasi_menit' => 5,
                    'passing_score' => 67,
                    'is_active' => true,
                ]
            );

            $questions = $perHeroQuestions[$hero->slug] ?? [
                [
                    'pertanyaan' => 'Dari daerah manakah asal perjuangan '.$hero->nama.'?',
                    'opsi' => [$hero->asal_daerah, 'Aceh', 'Banten', 'Maluku'],
                    'jawaban_benar' => 0,
                    'penjelasan' => $hero->nama.' berasal dan berjuang di wilayah '.$hero->asal_daerah.', Sulawesi Selatan.',
                ],
                [
                    'pertanyaan' => 'Apa kategori kepahlawanan '.$hero->nama.'?',
                    'opsi' => ['Pahlawan Nasional', 'Pahlawan Daerah Sulsel', 'Calon Pahlawan Nasional (TP2GD)'],
                    'jawaban_benar' => match ($hero->kategori) {
                        'nasional' => 0,
                        'daerah' => 1,
                        default => 2,
                    },
                    'penjelasan' => $hero->nama.' tercatat dalam kategori '.$hero->kategori_label.'.',
                ],
            ];

            $this->syncQuestions($quiz, $questions);
        }
    }

    /**
     * @param  array<int, array{pertanyaan: string, opsi: array<int, string>, jawaban_benar: int, penjelasan: string}>  $questions
     */
    private function syncQuestions(Quiz $quiz, array $questions): void
    {
        $quiz->questions()->delete();

        foreach ($questions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'pertanyaan' => $q['pertanyaan'],
                'opsi' => $q['opsi'],
                'jawaban_benar' => $q['jawaban_benar'],
                'penjelasan' => $q['penjelasan'],
                'urutan' => $index + 1,
            ]);
        }
    }
}
