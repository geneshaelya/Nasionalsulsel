<?php

namespace Tests\Feature;

use App\Models\ArchiveContribution;
use App\Models\GlossaryTerm;
use App\Models\Hero;
use App\Models\HistoricalSite;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\Tp2gdDocument;
use App\Models\Tp2gdGuide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortalFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_hero_strip_and_production_footer(): void
    {
        $hero = Hero::factory()->create([
            'nama' => 'Sultan Hasanuddin',
            'slug' => 'sultan-hasanuddin',
            'tahun_penanda' => 1667,
            'is_published' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee($hero->nama);
        $response->assertSee('Teknik Komputer dan Jaringan · Politeknik Negeri Ujung Pandang');
        $response->assertDontSee('Prototipe rancangan');
    }

    public function test_hero_directory_shows_overall_quiz_and_filters_heroes(): void
    {
        $gowaHero = Hero::factory()->create([
            'nama' => 'Sultan Hasanuddin',
            'slug' => 'sultan-hasanuddin',
            'asal_daerah' => 'Gowa',
            'kategori' => 'nasional',
        ]);

        $boneHero = Hero::factory()->create([
            'nama' => 'Andi Muhammad Jusuf Amir',
            'slug' => 'andi-muhammad-jusuf',
            'asal_daerah' => 'Bone',
            'kategori' => 'nasional',
        ]);

        Quiz::create([
            'hero_id' => null,
            'slug' => 'kuis-umum-pahlawan-sulsel',
            'judul' => 'Kuis Umum Pahlawan Nasional Sulawesi Selatan',
            'durasi_menit' => 15,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        $response = $this->get(route('heroes.index', ['daerah' => 'Bone']));

        $response->assertOk();
        $response->assertSee('Kuis Umum Pahlawan Nasional Sulawesi Selatan');
        $response->assertSee($boneHero->nama);
        $response->assertDontSee($gowaHero->nama);
    }

    public function test_hero_detail_page_renders_biography_tts_and_quiz_link(): void
    {
        $hero = Hero::factory()->create([
            'nama' => 'Andi Muhammad Jusuf Amir',
            'slug' => 'andi-muhammad-jusuf',
            'asal_daerah' => 'Bone',
            'tahun_penanda' => 2026,
            'is_published' => true,
        ]);

        $quiz = Quiz::create([
            'hero_id' => $hero->id,
            'slug' => 'kuis-'.$hero->slug,
            'judul' => 'Kuis Biografi: '.$hero->nama,
            'durasi_menit' => 5,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        HistoricalSite::factory()->create([
            'hero_id' => $hero->id,
            'nama' => 'Makam Jenderal M. Jusuf',
            'slug' => 'makam-m-jusuf',
            'is_published' => true,
        ]);

        $response = $this->get(route('heroes.show', $hero->slug));

        $response->assertOk();
        $response->assertSee($hero->nama);
        $response->assertSee('Dengarkan Biografi (TTS)');
        $response->assertSee('Makam Jenderal M. Jusuf');
        $response->assertSee(route('quiz.show', $quiz->slug));
    }

    public function test_map_page_and_sites_api_return_published_sites(): void
    {
        $site = HistoricalSite::factory()->create([
            'nama' => 'TMP Panaikang Makassar',
            'slug' => 'tmp-panaikang-makassar',
            'kabupaten_kota' => 'Kota Makassar',
            'is_published' => true,
        ]);

        $this->get(route('map.index'))
            ->assertOk()
            ->assertSee($site->nama);

        $this->getJson(route('api.sites'))
            ->assertOk()
            ->assertJsonFragment([
                'slug' => 'tmp-panaikang-makassar',
                'kabupaten_kota' => 'Kota Makassar',
            ]);
    }

    public function test_tp2gd_page_and_pdf_download_work(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('tp2gd/test-panduan.pdf', '%PDF-1.4 sample');

        Tp2gdGuide::create([
            'tahap_nomor' => 1,
            'judul' => 'Pengusulan Awal',
            'ringkasan' => 'Ringkasan tahap awal',
            'deskripsi' => 'Deskripsi lengkap pengusulan TP2GD.',
            'persyaratan' => ['Surat usulan'],
            'is_active' => true,
        ]);

        $doc = Tp2gdDocument::create([
            'judul' => 'Panduan TP2GD',
            'kategori' => 'panduan',
            'file_path' => 'tp2gd/test-panduan.pdf',
            'ukuran_kb' => 12,
            'is_active' => true,
        ]);

        $this->get(route('tp2gd.index'))
            ->assertOk()
            ->assertSee('Pengusulan Awal')
            ->assertSee('Panduan TP2GD');

        $this->get(route('tp2gd.download', $doc))
            ->assertOk();
    }

    public function test_quiz_submission_and_pdf_certificate_generation(): void
    {
        $quiz = Quiz::create([
            'hero_id' => null,
            'slug' => 'kuis-umum',
            'judul' => 'Kuis Umum Pahlawan Sulsel',
            'durasi_menit' => 10,
            'passing_score' => 50,
            'is_active' => true,
        ]);

        $q1 = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'pertanyaan' => 'Julukan Sultan Hasanuddin adalah?',
            'opsi' => ['Ayam Jantan dari Timur', 'Macan Asia'],
            'jawaban_benar' => 0,
            'penjelasan' => 'Belanda menjuluki beliau De Haantjes van het Oosten.',
            'urutan' => 1,
        ]);

        $this->get(route('quiz.index'))
            ->assertOk()
            ->assertSee('Kuis Umum Pahlawan Sulsel');

        $this->get(route('quiz.show', $quiz->slug))
            ->assertOk()
            ->assertSee($q1->pertanyaan);

        $response = $this->post(route('quiz.submit', $quiz->slug), [
            'nama_peserta' => 'Budi Santoso',
            'asal_instansi' => 'Politeknik Negeri Ujung Pandang',
            'answers' => [
                $q1->id => 0,
            ],
        ]);

        $attempt = QuizAttempt::query()->firstOrFail();
        $this->assertTrue($attempt->lulus);
        $this->assertSame(100, $attempt->persentase);
        $this->assertNotNull($attempt->nomor_sertifikat);

        $response->assertRedirect(route('quiz.result', [$quiz->slug, $attempt->id]));

        $this->get(route('quiz.result', [$quiz->slug, $attempt->id]))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee($attempt->nomor_sertifikat);

        $certResponse = $this->get(route('quiz.certificate', $attempt->nomor_sertifikat));
        $certResponse->assertOk();
        $this->assertStringStartsWith('%PDF-', $certResponse->getContent());
    }

    public function test_public_contribution_requires_valid_captcha_and_saves_as_draft(): void
    {
        $hero = Hero::factory()->create(['is_published' => true]);

        $this->withSession(['contribution_captcha_answer' => 9])
            ->post(route('contributions.store'), [
                'hero_id' => $hero->id,
                'nama_pengirim' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'judul' => 'Foto Keluarga Masa Revolusi',
                'jenis_kontribusi' => 'foto_arsip',
                'isi_catatan' => 'Catatan sejarah perjuangan keluarga kami di Makassar tahun 1946.',
                'captcha_answer' => 99,
            ])
            ->assertSessionHasErrors('captcha_answer');

        $this->assertDatabaseCount('archive_contributions', 0);

        $this->withSession(['contribution_captcha_answer' => 9])
            ->post(route('contributions.store'), [
                'hero_id' => $hero->id,
                'nama_pengirim' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'judul' => 'Foto Keluarga Masa Revolusi',
                'jenis_kontribusi' => 'foto_arsip',
                'isi_catatan' => 'Catatan sejarah perjuangan keluarga kami di Makassar tahun 1946.',
                'captcha_answer' => 9,
            ])
            ->assertRedirect(route('contributions.create'))
            ->assertSessionHas('success');

        $contribution = ArchiveContribution::query()->firstOrFail();
        $this->assertSame('draft', $contribution->status);
    }

    public function test_glossary_and_about_pages_render_and_admin_panel_access_is_enforced(): void
    {
        GlossaryTerm::factory()->create([
            'istilah' => 'Siri’ na Pacce',
            'bahasa' => 'Makassar',
            'is_published' => true,
        ]);

        $this->get(route('glossary.index'))
            ->assertOk()
            ->assertSee('Siri’ na Pacce');

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Teknik Komputer dan Jaringan');

        $admin = User::factory()->admin()->create();
        $publicUser = User::factory()->create(['role' => 'public']);

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get('/admin/heroes')->assertOk();
        $this->actingAs($admin)->get('/admin/historical-sites')->assertOk();
        $this->actingAs($admin)->get('/admin/quizzes')->assertOk();
        $this->actingAs($admin)->get('/admin/archive-contributions')->assertOk();
        $this->actingAs($admin)->get('/admin/glossary-terms')->assertOk();
        $this->actingAs($admin)->get('/admin/tp2gd-guides')->assertOk();
        $this->actingAs($admin)->get('/admin/tp2gd-documents')->assertOk();
        $this->actingAs($publicUser)->get('/admin')->assertForbidden();
    }
}
