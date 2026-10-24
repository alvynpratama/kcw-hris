<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $today = now()->startOfDay();
        $deadline = $today->copy()->addDays(30);

        $activeContractQuery = Employee::query()
            ->whereDate('contract_start', '<=', $today)
            ->whereDate('contract_end', '>=', $today);

        $totalEmployeeCount = Employee::count();
        $activeEmployeeCount = (clone $activeContractQuery)->count();
        $upcomingContractCount = Employee::query()
            ->whereDate('contract_start', '>', $today)
            ->count();
        $upcomingWithin30Count = Employee::query()
            ->whereDate('contract_start', '>', $today)
            ->whereDate('contract_start', '<=', $deadline)
            ->count();
        $expiringContractCount = (clone $activeContractQuery)
            ->whereDate('contract_end', '<=', $deadline)
            ->count();
        $expiredContractCount = Employee::query()
            ->whereDate('contract_end', '<', $today)
            ->count();
        $placementCompanyCount = (clone $activeContractQuery)
            ->distinct()
            ->count('placement_company');

        $placementDistribution = (clone $activeContractQuery)
            ->selectRaw('placement_company, COUNT(*) as total')
            ->groupBy('placement_company')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $attentionContracts = Employee::query()
            ->where(function ($query) use ($today, $deadline) {
                $query
                    ->where(function ($upcomingQuery) use ($today, $deadline) {
                        $upcomingQuery
                            ->whereDate('contract_start', '>', $today)
                            ->whereDate('contract_start', '<=', $deadline);
                    })
                    ->orWhere(function ($expiringQuery) use ($today, $deadline) {
                        $expiringQuery
                            ->whereDate('contract_start', '<=', $today)
                            ->whereDate('contract_end', '>=', $today)
                            ->whereDate('contract_end', '<=', $deadline);
                    })
                    ->orWhereDate('contract_end', '<', $today);
            })
            ->get()
            ->sortBy(function (Employee $employee) use ($today) {
                $contractStart = $employee->contract_start->copy()->startOfDay();
                $contractEnd = $employee->contract_end->copy()->startOfDay();

                if ($contractEnd->lt($today)) {
                    return '1-' . $contractEnd->format('Ymd');
                }

                if ($contractStart->lte($today)) {
                    return '2-' . $contractEnd->format('Ymd');
                }

                return '3-' . $contractStart->format('Ymd');
            })
            ->take(8)
            ->values();

        return view('dashboard', compact(
            'totalEmployeeCount',
            'activeEmployeeCount',
            'upcomingContractCount',
            'upcomingWithin30Count',
            'expiringContractCount',
            'expiredContractCount',
            'placementCompanyCount',
            'placementDistribution',
            'attentionContracts'
        ));
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/input-karyawan', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/input-karyawan', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/data-karyawan', [EmployeeController::class, 'index'])->name('employees.index');

    Route::get('/data-karyawan/{employee}/dokumen/{type}', [EmployeeController::class, 'document'])
        ->where('type', 'face|ktp|kk')
        ->name('employees.document');
});
