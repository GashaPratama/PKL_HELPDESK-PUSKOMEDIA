    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\RegistrasiController;
    use App\Http\Controllers\Superadmin\UserController;
    use App\Http\Controllers\Superadmin\TicketController;
    use App\Http\Controllers\Customer\ProfileController;
    use App\Http\Controllers\Customer\LaporanController;
    use App\Http\Controllers\CustomerService\KategoriController;

    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTES (tanpa login)
    |--------------------------------------------------------------------------
    */
    Route::get('/', fn () => view('landing-page'));

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrasiController::class, 'register'])->name('register.post');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT (butuh auth)
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:superadmin'])
        ->prefix('superadmin')
        ->name('superadmin.')
        ->group(function () {

            // Dashboard
    Route::get('/dashboard', function () {
        $users = \App\Models\User::orderBy('id_user', 'desc')->paginate(10);

        // tiket terbaru + relasi kategori
        $recentTickets = \App\Models\Laporan::with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('superadmin.dashboard', compact('users', 'recentTickets'));
    })->name('dashboard');

            // Manajemen User
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/',            [UserController::class, 'index'])->name('index');
                Route::get('/create',      [UserController::class, 'create'])->name('create');
                Route::post('/',           [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit',   [UserController::class, 'edit'])->name('edit');
                Route::put('/{id}',        [UserController::class, 'update'])->name('update');
                Route::delete('/{id}',     [UserController::class, 'destroy'])->name('destroy');
            });

            // Kelola Tiket
            Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

            // Update status tiket
            Route::put('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

            // Lihat daftar kategori unik tiket
            Route::get('/tickets/categories', [TicketController::class, 'listCategories'])->name('tickets.categories');
        });

    /*
    |--------------------------------------------------------------------------
    | ALIAS ROUTE LAMA UNTUK KOMPATIBILITAS LOGIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:superadmin'])->get('/dashboard/superadmin', function () {
        return redirect()->route('superadmin.dashboard');
    })->name('dashboard.superadmin');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER SERVICE AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:customer_service'])->group(function () {
        Route::get('/dashboard/customerservice', fn () => view('customerservice.dashboard'))
            ->name('dashboard.customerservice');

        // Kategori
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/',               [KategoriController::class, 'index'])->name('index');
            Route::post('/',               [KategoriController::class, 'store'])->name('store');
            Route::delete('/{kategori}',   [KategoriController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | TEKNISI AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:teknisi'])->group(function () {
        Route::get('/dashboard/teknisi', fn () => view('teknisi.dashboard'))
            ->name('dashboard.teknisi');
    });

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:customer'])->group(function () {

        // Dashboard Customer
        Route::get('/dashboard/customer', [LaporanController::class, 'dashboard'])
            ->name('dashboard.customer');

        // Laporan (ticket)
        Route::prefix('laporan')->name('customer.laporan.')->group(function () {
            Route::get('/',           [LaporanController::class, 'index'])->name('index');
            Route::get('/create',     [LaporanController::class, 'create'])->name('create');
            Route::post('/store',     [LaporanController::class, 'store'])->name('store');
            Route::get('/{id}',       [LaporanController::class, 'show'])->name('show');

            // Edit & Hapus
            Route::get('/{id}/edit',  [LaporanController::class, 'edit'])->name('edit');
            Route::put('/{id}',       [LaporanController::class, 'update'])->name('update');
            Route::delete('/{id}',    [LaporanController::class, 'destroy'])->name('destroy');
        });

        // Profil Customer
        Route::prefix('profil')->name('customer.')->group(function () {
            Route::get('/',                 [ProfileController::class, 'index'])->name('profil');

            // Foto
            Route::get('/edit-foto',        [ProfileController::class, 'editFoto'])->name('edit-foto');
            Route::post('/update-foto',     [ProfileController::class, 'updateFoto'])->name('update-foto');

            // Nama
            Route::get('/edit-nama',        [ProfileController::class, 'editNama'])->name('edit-nama');
            Route::post('/update-nama',     [ProfileController::class, 'updateNama'])->name('update-nama');

            // Email
            Route::get('/edit-email',       [ProfileController::class, 'editEmail'])->name('edit-email');
            Route::post('/update-email',    [ProfileController::class, 'updateEmail'])->name('update-email');

            // Password
            Route::get('/edit-password',    [ProfileController::class, 'editPassword'])->name('edit-password');
            Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
        });
    });
