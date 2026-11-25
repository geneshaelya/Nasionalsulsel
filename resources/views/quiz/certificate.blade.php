<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat Apresiasi {{ $attempt->nomor_sertifikat }}</title>
    <style>
        @page {
            margin: 22px;
        }
        body {
            font-family: 'DejaVu Serif', Georgia, serif;
            background: #f6f3ea;
            color: #25231e;
            margin: 0;
            padding: 18px;
        }
        .outer-frame {
            border: 4px double #33291a;
            padding: 28px 36px;
            background: #fffdf6;
        }
        .inner-frame {
            border: 1px solid #b8892b;
            padding: 26px 32px;
            text-align: center;
        }
        .eyebrow {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #7b786d;
            margin-bottom: 6px;
        }
        .title {
            font-size: 34px;
            font-weight: bold;
            color: #33291a;
            letter-spacing: 2px;
            margin: 6px 0 4px;
        }
        .subtitle {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8b3a2b;
            margin-bottom: 22px;
        }
        .recipient {
            font-size: 30px;
            font-style: italic;
            font-weight: bold;
            color: #33291a;
            border-bottom: 1px solid #d6d3c5;
            display: inline-block;
            padding: 4px 28px 6px;
            margin: 8px 0 6px;
        }
        .instansi {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #5a574c;
            margin-bottom: 18px;
        }
        .desc {
            font-size: 14px;
            line-height: 1.6;
            max-width: 640px;
            margin: 0 auto 22px;
        }
        .meta-table {
            width: 100%;
            margin-top: 22px;
            border-collapse: collapse;
        }
        .meta-table td {
            width: 33.33%;
            vertical-align: bottom;
            text-align: center;
            font-size: 11px;
            color: #5a574c;
        }
        .sig-line {
            border-top: 1px solid #33291a;
            width: 190px;
            margin: 34px auto 4px;
            padding-top: 4px;
            font-weight: bold;
            color: #25231e;
        }
    </style>
</head>
<body>
    <div class="outer-frame">
        <div class="inner-frame">
            <div class="eyebrow">Dinas Sosial Provinsi Sulawesi Selatan · Portal Edukasi Sejarah</div>
            <div class="title">SERTIFIKAT APRESIASI</div>
            <div class="subtitle">Nomor: {{ $attempt->nomor_sertifikat }}</div>

            <div style="font-size: 13px; color: #5a574c;">Diberikan dengan penuh penghargaan kepada:</div>
            <div class="recipient">{{ $attempt->nama_peserta }}</div>
            <div class="instansi">{{ $attempt->asal_instansi }}</div>

            <div class="desc">
                Telah berhasil menyelesaikan dan dinyatakan <strong>LULUS</strong> pada evaluasi pembelajaran interaktif
                <strong>"{{ $quiz->judul }}"</strong> dengan perolehan skor
                <strong>{{ $attempt->persentase }}%</strong> ({{ $attempt->skor }} dari {{ $attempt->total_soal }} jawaban benar)
                sebagai bentuk kecintaan terhadap sejarah perjuangan Pahlawan Nasional Sulawesi Selatan.
            </div>

            <table class="meta-table">
                <tr>
                    <td>
                        <div>Ditetapkan di Makassar</div>
                        <div style="font-weight: bold; color: #25231e; margin-top: 3px;">
                            {{ $attempt->completed_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}
                        </div>
                    </td>
                    <td>
                        <div style="border: 1px solid #b8892b; padding: 6px 10px; display: inline-block; color: #8b3a2b; font-family: 'DejaVu Sans', sans-serif; font-size: 9px; letter-spacing: 1px;">
                            TERVERIFIKASI DIGITAL<br>PORTAL PAHLAWAN SULSEL
                        </div>
                    </td>
                    <td>
                        <div class="sig-line">Kurator Edukasi Sejarah</div>
                        <div>Bidang Kepahlawanan · Dinsos Sulsel</div>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px; font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #7b786d; letter-spacing: 1px;">
                Teknik Komputer dan Jaringan · Politeknik Negeri Ujung Pandang
            </div>
        </div>
    </div>
</body>
</html>
