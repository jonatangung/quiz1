<?php

namespace Tests\Feature;

use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WorkOrderTest extends TestCase
{
    public function test_work_order_form_requires_login(): void
    {
        $this->get('/servis/buat')->assertRedirect('/');
    }

    public function test_authenticated_staff_can_open_work_order_form(): void
    {
        $this->withSession(['u' => 'mekanik'])
            ->get('/servis/buat')
            ->assertOk()
            ->assertSee('Catat servis baru')
            ->assertSee('Merek dan tipe motor');
    }

    public function test_work_order_requires_customer_and_vehicle_details(): void
    {
        $this->withSession(['u' => 'mekanik'])
            ->from('/servis/buat')
            ->post('/servis', [])
            ->assertRedirect('/servis/buat')
            ->assertSessionHasErrors(['customer_name', 'motorcycle', 'status']);
    }

    public function test_work_order_report_shows_an_empty_state(): void
    {
        $this->view('reports.work_orders', [
            'orders' => collect(),
            'format' => 'excel',
        ])
            ->assertSee('Laporan Servis Bengkel')
            ->assertSee('Belum ada data servis.');
    }

    public function test_spare_part_form_requires_login(): void
    {
        $this->get('/suku-cadang/buat')->assertRedirect('/');
    }

    public function test_authenticated_staff_can_open_spare_part_form(): void
    {
        $this->withSession(['u' => 'mekanik'])
            ->get('/suku-cadang/buat')
            ->assertOk()
            ->assertSee('Tambah suku cadang')
            ->assertSee('Batas stok minimum');
    }

    public function test_spare_part_requires_a_code_and_stock_values(): void
    {
        $this->withSession(['u' => 'mekanik'])
            ->from('/suku-cadang/buat')
            ->post('/suku-cadang', [])
            ->assertRedirect('/suku-cadang/buat')
            ->assertSessionHasErrors(['code', 'name', 'stock', 'minimum_stock']);
    }

    public function test_dashboard_renders_service_and_spare_part_links(): void
    {
        $this->view('home', [
            'orders' => collect(),
            'parts' => collect(),
            'users' => collect(),
        ])
            ->assertSee(route('servis.buat'))
            ->assertSee(route('suku-cadang.buat'))
            ->assertSee('Data user')
            ->assertSee('Belum ada user.')
            ->assertSee('Belum ada data servis.')
            ->assertSee('Belum ada data suku cadang.');
    }

    public function test_user_registration_is_not_available(): void
    {
        $this->get('/girasya')->assertNotFound();
        $this->post('/input')->assertNotFound();
        $this->get('/')->assertDontSee('register');
    }

    public function test_karyawan_page_requires_login(): void
    {
        $this->get('/karyawan')->assertRedirect('/');
    }

    public function test_karyawan_page_reads_records_from_the_karyawan_table(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        \Illuminate\Support\Facades\Schema::connection('sqlite')->create('karyawan', function ($table): void {
            $table->increments('id_kry');
            $table->unsignedInteger('id_user');
            $table->string('nama_kry');
            $table->string('alamat_kry');
            $table->string('jk_kry');
            $table->string('foto')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('nik')->nullable();
            $table->string('id_jabatan')->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->string('tpt_lhr')->nullable();
        });

        DB::connection('sqlite')->table('karyawan')->insert([
            'id_user' => 8,
            'nama_kry' => 'Nama Tes Karyawan',
            'alamat_kry' => 'Alamat Tes',
            'jk_kry' => 'w',
        ]);

        $this->withSession(['u' => 'mekanik'])
            ->get('/karyawan')
            ->assertOk()
            ->assertSee('Nama Tes Karyawan')
            ->assertSee('Alamat Tes')
            ->assertSee('Data Karyawan');
    }

    public function test_tkry_submit_saves_user_and_employee_records(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Artisan::call('migrate', [
            '--database' => 'sqlite',
            '--path' => 'database/migrations/2026_10_15_000002_create_user_and_karyawan_tables.php',
            '--force' => true,
        ]);
        Schema::connection('sqlite')->create('users', function ($table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Artisan::call('migrate', [
            '--database' => 'sqlite',
            '--path' => 'database/migrations/2026_10_17_230000_add_username_and_level_to_users_table.php',
            '--force' => true,
        ]);

        $this->post('/aksi_tkry', [
            'u' => 'Septi',
            'p' => '123',
            'e' => 'septi@example.com',
            'l' => '3',
            'nama' => 'Septi',
            'alamat' => 'Hati Zano',
            'jk' => 'P',
        ])
            ->assertRedirect('/karyawan');

        $user = DB::connection('sqlite')->table('users')->where('username', 'Septi')->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('123', $user->password));

        $this->assertDatabaseHas('karyawan', [
            'id_user' => $user->id,
            'nama_kry' => 'Septi',
            'alamat_kry' => 'Hati Zano',
            'jk_kry' => 'P',
        ], 'sqlite');

        $this->post('/login', ['u' => 'Septi', 'p' => '123'])
            ->assertRedirect('/home');
    }

    public function test_user_edit_form_only_edits_name_and_email(): void
    {
        $this->view('edit', [
            'errors' => new ViewErrorBag(),
            'user' => (object) [
                'id' => 1,
                'name' => 'Mekanik',
                'email' => 'mekanik@example.com',
            ],
        ])
            ->assertSee(route('pengguna.update', 1))
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertDontSee('name="password"', false);
    }

    public function test_authenticated_dashboard_loads_from_the_configured_database(): void
    {
        $this->withSession(['u' => 'mekanik'])
            ->get('/home')
            ->assertOk()
            ->assertSee('Daftar pekerjaan servis')
            ->assertSee('Persediaan suku cadang')
            ->assertSee(route('suku-cadang.buat'));
    }

    public function test_spare_part_form_uses_registered_update_route(): void
    {
        $this->view('spare_parts.form', [
            'errors' => new ViewErrorBag(),
            'part' => (object) [
                'id' => 1,
                'code' => 'OLI-001',
                'name' => 'Oli mesin',
                'category' => 'Oli',
                'unit' => 'botol',
                'stock' => 5,
                'minimum_stock' => 2,
                'price' => 50000,
            ],
        ])
            ->assertSee(route('suku-cadang.update', 1))
            ->assertSee('Simpan perubahan');
    }
}
