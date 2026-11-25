<?php

namespace Database\Seeders;

use App\Models\Tp2gdDocument;
use App\Models\Tp2gdGuide;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Tp2gdSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            [
                'tahap_nomor' => 1,
                'judul' => 'Usulan Masyarakat & Pemerintah Kabupaten/Kota',
                'ringkasan' => 'Pengajuan usulan tokoh dari masyarakat, keluarga, akademisi, atau instansi kepada Bupati/Wali Kota setempat melalui Dinas Sosial Kab/Kota.',
                'deskripsi' => 'Berdasarkan UU No. 20 Tahun 2009 tentang Gelar, Tanda Jasa, dan Tanda Kehormatan serta Permensos RI No. 15 Tahun 2012, setiap warga negara atau lembaga dapat mengajukan usulan calon Pahlawan Nasional. Pengusul menyiapkan naskah riwayat hidup awal, bukti keterlibatan perjuangan tanpa cacat, serta dukungan masyarakat.',
                'persyaratan' => [
                    'Surat permohonan resmi dari pengusul (masyarakat/keluarga/organisasi) kepada Bupati atau Wali Kota.',
                    'Biodata lengkap, silsilah keluarga, serta riwayat perjuangan tokoh yang telah wafat.',
                    'Bukti primer/sekunder sejarah (arsip surat kabar sejaman, dokumen militer/pemerintahan, foto arsip, atau kesaksian tertulis).',
                    'Surat pernyataan tidak pernah mengkhianati bangsa dan negara serta memenuhi syarat integritas moral.',
                ],
                'instansi_terkait' => 'Dinas Sosial Kabupaten/Kota & Keluarga/Pengusul Masyarakat',
                'estimasi_waktu' => '1 – 2 Bulan',
                'is_active' => true,
            ],
            [
                'tahap_nomor' => 2,
                'judul' => 'Verifikasi & Kajian Awal TP2GD Kabupaten/Kota',
                'ringkasan' => 'Tim Peneliti dan Pengkaji Gelar Daerah (TP2GD) tingkat Kabupaten/Kota memverifikasi berkas dan menyelenggarakan diskusi publik daerah.',
                'deskripsi' => 'Bupati/Wali Kota membentuk TP2GD Kabupaten/Kota yang beranggotakan sejarawan, akademisi, budayawan, dan unsur pemerintah daerah untuk meneliti kelayakan substantif dan keabsahan fakta sejarah calon.',
                'persyaratan' => [
                    'Berita acara rapat penelitian dan verifikasi lapangan oleh TP2GD Kabupaten/Kota.',
                    'Dokumentasi situs sejarah, makam, atau monumen yang terkait dengan perjuangan tokoh.',
                    'Rekomendasi tertulis dari Bupati/Wali Kota untuk diteruskan kepada Gubernur Sulawesi Selatan.',
                ],
                'instansi_terkait' => 'TP2GD Kabupaten/Kota & Bupati/Wali Kota',
                'estimasi_waktu' => '2 – 3 Bulan',
                'is_active' => true,
            ],
            [
                'tahap_nomor' => 3,
                'judul' => 'Pengajuan ke Dinas Sosial Provinsi & TP2GD Sulsel',
                'ringkasan' => 'Berkas usulan yang telah lolos tahap kabupaten/kota diserahkan secara resmi kepada Gubernur Sulawesi Selatan melalui Dinas Sosial Provinsi.',
                'deskripsi' => 'Dinas Sosial Provinsi Sulawesi Selatan melalui Bidang Pemberdayaan Sosial & Kepahlawanan bertindak sebagai sekretariat TP2GD Provinsi yang melakukan pemeriksaan administrasi berkas sebelum disidangkan di tingkat provinsi.',
                'persyaratan' => [
                    'Surat Pengantar resmi dari Bupati/Wali Kota kepada Gubernur Sulawesi Selatan Cq. Kepala Dinas Sosial Provinsi Sulsel.',
                    'Bundel naskah akademik/biografi tokoh minimal 30 halaman beserta lampiran sumber sejarah yang terverifikasi.',
                    'Dokumen bukti pengakuan masyarakat (nama jalan, bangunan publik, atau peringatan lokal).',
                ],
                'instansi_terkait' => 'Dinas Sosial Provinsi Sulawesi Selatan (Sekretariat TP2GD Provinsi)',
                'estimasi_waktu' => '1 Bulan',
                'is_active' => true,
            ],
            [
                'tahap_nomor' => 4,
                'judul' => 'Seminar Nasional/Daerah & Pengesahan TP2GD Provinsi',
                'ringkasan' => 'Pelaksanaan seminar ilmiah sejarah bersama guru besar, sejarawan, dan saksi sejarah guna menguji keabsahan naskah akademik tokoh.',
                'deskripsi' => 'TP2GD Provinsi Sulawesi Selatan mengadakan seminar terbuka yang menghadirkan pakar sejarah nasional/daerah untuk membahas dampak perjuangan tokoh secara lintas daerah atau nasional. Hasil seminar menjadi bagian utama pertimbangan Gubernur.',
                'persyaratan' => [
                    'Prosiding atau notulensi resmi Seminar Pengusulan Gelar Pahlawan Nasional Tingkat Provinsi.',
                    'Daftar hadir, makalah pembanding dari pakar sejarah/akademisi perguruan tinggi.',
                    'Berita acara sidang pleno persetujuan TP2GD Provinsi Sulawesi Selatan.',
                ],
                'instansi_terkait' => 'TP2GD Provinsi Sulsel, Sejarawan & Perguruan Tinggi',
                'estimasi_waktu' => '2 – 4 Bulan',
                'is_active' => true,
            ],
            [
                'tahap_nomor' => 5,
                'judul' => 'Rekomendasi Gubernur ke Kementerian Sosial RI (TP2GP)',
                'ringkasan' => 'Gubernur Sulawesi Selatan mengajukan berkas final kepada Menteri Sosial RI untuk ditelaah oleh Tim Peneliti dan Pengkaji Gelar Pusat (TP2GP).',
                'deskripsi' => 'Setelah mendapat persetujuan TP2GD Provinsi, Gubernur menerbitkan surat rekomendasi pengusulan kepada Presiden melalui Menteri Sosial RI paling lambat batas waktu tahun berjalan (umumnya triwulan pertama sebelum peringatan Hari Pahlawan).',
                'persyaratan' => [
                    'Surat Rekomendasi resmi Gubernur Sulawesi Selatan kepada Menteri Sosial RI.',
                    'Seluruh berkas riset sejarah, video dokumenter/arsip, serta surat persetujuan ahli waris.',
                    'Verifikasi silang oleh Direktorat Kepahlawanan, Keperintisan, Kesetiakawanan, dan Restorasi Sosial Kemensos RI.',
                ],
                'instansi_terkait' => 'Gubernur Sulawesi Selatan & Kementerian Sosial RI (TP2GP)',
                'estimasi_waktu' => '3 – 6 Bulan',
                'is_active' => true,
            ],
            [
                'tahap_nomor' => 6,
                'judul' => 'Pertimbangan Dewan Gelar & Keputusan Presiden RI',
                'ringkasan' => 'Dewan Gelar, Tanda Jasa, dan Tanda Kehormatan menyampaikan pertimbangan akhir kepada Presiden RI untuk ditetapkan dengan Keppres.',
                'deskripsi' => 'Usulan yang lolos seleksi TP2GP Pusat diajukan Menteri Sosial kepada Presiden RI melalui Dewan Gelar. Pengumuman dan penganugerahan resmi Gelar Pahlawan Nasional lazimnya dilaksanakan di Istana Negara menjelang Hari Pahlawan 10 November.',
                'persyaratan' => [
                    'Sidang Dewan Gelar, Tanda Jasa, dan Tanda Kehormatan Republik Indonesia.',
                    'Penetapan Keputusan Presiden (Keppres) tentang Penganugerahan Gelar Pahlawan Nasional.',
                    'Penyerahan piagam dan tanda kehormatan kepada ahli waris tokoh di Istana Negara.',
                ],
                'instansi_terkait' => 'Dewan Gelar RI & Presiden Republik Indonesia',
                'estimasi_waktu' => 'Penetapan Tahunan (Hari Pahlawan 10 November)',
                'is_active' => true,
            ],
        ];

        foreach ($guides as $guide) {
            Tp2gdGuide::updateOrCreate(
                ['tahap_nomor' => $guide['tahap_nomor']],
                $guide
            );
        }

        Storage::disk('public')->makeDirectory('tp2gd');

        $documents = [
            [
                'judul' => 'Panduan Tata Cara Pengusulan Gelar Pahlawan Nasional (TP2GD Sulsel)',
                'kategori' => 'panduan',
                'deskripsi' => 'Dokumen panduan lengkap mengenai landasan hukum (UU No. 20 Tahun 2009), kriteria umum dan khusus calon pahlawan, serta alur kerja TP2GD Sulawesi Selatan.',
                'file_path' => 'tp2gd/panduan-pengusulan-tp2gd-sulsel.pdf',
                'urutan' => 1,
                'pdf_body' => [
                    'sub' => 'Sekretariat TP2GD · Dinas Sosial Provinsi Sulawesi Selatan',
                    'sections' => [
                        ['title' => '1. Landasan Hukum Pengusulan', 'items' => [
                            'Undang-Undang RI Nomor 20 Tahun 2009 tentang Gelar, Tanda Jasa, dan Tanda Kehormatan.',
                            'Peraturan Pemerintah Nomor 35 Tahun 2010 tentang Pelaksanaan UU Nomor 20 Tahun 2009.',
                            'Peraturan Menteri Sosial RI tentang Tata Cara Pengusulan Gelar Pahlawan Nasional.',
                        ]],
                        ['title' => '2. Syarat Umum & Khusus Calon Pahlawan Nasional', 'items' => [
                            'Warga Negara Indonesia yang berjuang di wilayah Negara Kesatuan Republik Indonesia dan telah meninggal dunia.',
                            'Memiliki integritas moral dan keteladanan serta berjasa luar biasa bagi bangsa dan negara.',
                            'Tidak pernah melakukan perbuatan tercela yang merusak nilai perjuangan dan tidak pernah mengkhianati bangsa.',
                            'Memimpin atau melakukan perjuangan bersenjata, perjuangan politik, atau bidang keilmuan/kebudayaan yang berdampak nasional.',
                        ]],
                        ['title' => '3. Sekretariat Layanan Informasi', 'items' => [
                            'Bidang Pemberdayaan Sosial & Kepahlawanan, Dinas Sosial Provinsi Sulawesi Selatan, Jl. A. P. Pettarani No. 59, Makassar.',
                        ]],
                    ],
                ],
            ],
            [
                'judul' => 'Daftar Periksa (Checklist) Kelengkapan Berkas Usulan TP2GD',
                'kategori' => 'formulir',
                'deskripsi' => 'Lembar kendali bagi pengusul daerah, ahli waris, dan Dinas Sosial Kabupaten/Kota untuk memastikan kelengkapan dokumen administratif dan historis.',
                'file_path' => 'tp2gd/checklist-kelengkapan-berkas-tp2gd.pdf',
                'urutan' => 2,
                'pdf_body' => [
                    'sub' => 'Formulir Verifikasi Administrasi · TP2GD Provinsi Sulawesi Selatan',
                    'sections' => [
                        ['title' => 'A. Dokumen Administrasi Pemerintahan', 'items' => [
                            '[ ] Surat usulan resmi dari masyarakat/lembaga kepada Bupati/Wali Kota.',
                            '[ ] Surat pengantar dan rekomendasi Bupati/Wali Kota kepada Gubernur Sulsel.',
                            '[ ] Surat Keputusan pembentukan Tim Peneliti dan Pengkaji Gelar Daerah (TP2GD) Kab/Kota.',
                            '[ ] Berita Acara Rapat Verifikasi TP2GD Kab/Kota & Berita Acara Seminar Provinsi.',
                        ]],
                        ['title' => 'B. Dokumen Historis & Akademik', 'items' => [
                            '[ ] Naskah Biografi & Sejarah Perjuangan Tokoh (dilengkapi catatan kaki dan daftar pustaka ilmiah).',
                            '[ ] Fotokopi arsip primer sezaman (surat kabar, surat keputusan, arsip militer, atau foto dokumentasi).',
                            '[ ] Dokumentasi bukti fisik pengabadian nama tokoh (monumen, makam, nama jalan, museum).',
                            '[ ] Surat Pernyataan Persetujuan Ahli Waris bermeterai cukup.',
                        ]],
                    ],
                ],
            ],
            [
                'judul' => 'Templat Ringkasan Biografi & Surat Pernyataan Ahli Waris',
                'kategori' => 'template',
                'deskripsi' => 'Format baku penyusunan riwayat hidup ringkas tokoh serta contoh surat pernyataan persetujuan keluarga/ahli waris calon pahlawan.',
                'file_path' => 'tp2gd/template-biografi-ahli-waris-tp2gd.pdf',
                'urutan' => 3,
                'pdf_body' => [
                    'sub' => 'Templat Resmi Penyusunan Berkas · Dinas Sosial Provinsi Sulawesi Selatan',
                    'sections' => [
                        ['title' => 'Format Sistematika Naskah Biografi Calon Pahlawan', 'items' => [
                            'BAB I: Latar Belakang Kelahiran, Pendidikan, dan Lingkungan Sosial-Budaya Daerah Asal.',
                            'BAB II: Kiprah Perjuangan dan Pengabdian (Kronologi Peristiwa & Peran Sentral Tokoh).',
                            'BAB III: Dampak Nasional/Lintas Daerah dan Pengaruhnya bagi Keutuhan NKRI.',
                            'BAB IV: Akhir Hayat, Lokasi Pemakaman, serta Bentuk Penghormatan Masyarakat.',
                        ]],
                        ['title' => 'Butir Surat Pernyataan Ahli Waris', 'items' => [
                            'Identitas lengkap ahli waris yang sah disertai bukti silsilah keluarga.',
                            'Pernyataan persetujuan tanpa keberatan atas pengajuan gelar atas nama almarhum/almarhumah.',
                            'Kesediaan menyerahkan salinan arsip keluarga guna keperluan penelitian TP2GD dan TP2GP.',
                        ]],
                    ],
                ],
            ],
        ];

        foreach ($documents as $docData) {
            $pdfBody = $docData['pdf_body'];
            unset($docData['pdf_body']);

            $html = $this->buildPdfHtml($docData['judul'], $pdfBody['sub'], $pdfBody['sections']);
            $pdfContent = Pdf::loadHTML($html)->setPaper('a4', 'portrait')->output();
            Storage::disk('public')->put($docData['file_path'], $pdfContent);

            $sizeKb = max(1, (int) ceil(strlen($pdfContent) / 1024));

            Tp2gdDocument::updateOrCreate(
                ['file_path' => $docData['file_path']],
                array_merge($docData, [
                    'ukuran_kb' => $sizeKb,
                    'is_active' => true,
                ])
            );
        }
    }

    /**
     * @param  array<int, array{title: string, items: array<int, string>}>  $sections
     */
    private function buildPdfHtml(string $title, string $subtitle, array $sections): string
    {
        $sectionsHtml = '';
        foreach ($sections as $section) {
            $itemsHtml = '';
            foreach ($section['items'] as $item) {
                $itemsHtml .= '<li>'.e($item).'</li>';
            }
            $sectionsHtml .= '<h2 style="font-size:14px;color:#33291a;border-bottom:1px solid #d6d3c5;padding-bottom:4px;margin-top:18px;">'
                .e($section['title'])
                .'</h2><ul style="font-size:12px;line-height:1.6;color:#25231e;">'
                .$itemsHtml
                .'</ul>';
        }

        return '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Serif,serif;color:#25231e;margin:36px;background:#fff;}</style></head><body>'
            .'<div style="border-bottom:2px solid #33291a;padding-bottom:12px;margin-bottom:20px;">'
            .'<div style="font-family:DejaVu Sans,sans-serif;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#7b786d;">Dinas Sosial Provinsi Sulawesi Selatan · TP2GD</div>'
            .'<h1 style="font-size:20px;margin:6px 0 4px;color:#33291a;">'.e($title).'</h1>'
            .'<div style="font-size:12px;color:#5a574c;">'.e($subtitle).'</div>'
            .'</div>'
            .$sectionsHtml
            .'<div style="margin-top:34px;border-top:1px solid #d6d3c5;padding-top:10px;font-family:DejaVu Sans,sans-serif;font-size:10px;color:#7b786d;">'
            .'Portal Edukasi Pahlawan Nasional Sulawesi Selatan · Teknik Komputer dan Jaringan, Politeknik Negeri Ujung Pandang'
            .'</div></body></html>';
    }
}
