<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');
        $today = now()->toDateString();

        $employees = Employee::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($employeeQuery) use ($search) {
                    $employeeQuery
                        ->where('full_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('placement_company', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', function ($query) use ($today) {
                $query
                    ->whereDate('contract_start', '<=', $today)
                    ->whereDate('contract_end', '>=', $today);
            })
            ->when($status === 'inactive', function ($query) use ($today) {
                $query->where(function ($employeeQuery) use ($today) {
                    $employeeQuery
                        ->whereDate('contract_start', '>', $today)
                        ->orWhereDate('contract_end', '<', $today);
                });
            })
            ->orderBy('full_name')
            ->paginate(12)
            ->withQueryString();

        return view('employees.index', compact(
            'employees',
            'search',
            'status'
        ));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $employeeData = Arr::except($validated, [
            'face_photo',
            'ktp_file',
            'kk_file',
        ]);

        $employeeData['bank_account_holder'] =
            $validated['bank_account_holder'] ?: $validated['full_name'];

        $employeeData['face_photo_path'] = $request
            ->file('face_photo')
            ->store('employees/face-photos', 'local');

        $employeeData['ktp_file_path'] = $request
            ->file('ktp_file')
            ->store('employees/ktp-files', 'local');

        $employeeData['kk_file_path'] = $request
            ->file('kk_file')
            ->store('employees/kk-files', 'local');

        $employee = Employee::create($employeeData);

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                "Data karyawan {$employee->full_name} berhasil ditambahkan."
            );
    }

    public function document(Employee $employee, string $type)
    {
        $path = match ($type) {
            'face' => $employee->face_photo_path,
            'ktp' => $employee->ktp_file_path,
            'kk' => $employee->kk_file_path,
            default => null,
        };

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('local')->path($path),
            [
                'Cache-Control' => 'private, no-store',
            ]
        );
    }

    private function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'nik' => ['required', 'string', 'max:30', 'unique:employees,nik'],
            'address' => ['required', 'string'],

            'placement_company' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:100'],

            'bank_name' => ['required', 'string', 'max:100'],
            'bank_account_number' => ['required', 'string', 'max:50'],
            'bank_account_holder' => ['nullable', 'string', 'max:150'],

            'contract_start' => ['required', 'date'],
            'contract_end' => ['required', 'date', 'after_or_equal:contract_start'],

            'status' => ['required', Rule::in(['active', 'inactive'])],

            'face_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'ktp_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],

            'kk_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ];
    }

    private function messages(): array
    {
        return [
            'full_name.required' => 'Nama karyawan wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'nik.required' => 'Nomor KTP wajib diisi.',
            'nik.unique' => 'Nomor KTP sudah terdaftar pada data karyawan lain.',
            'address.required' => 'Alamat wajib diisi.',

            'placement_company.required' => 'Perusahaan penempatan wajib diisi.',
            'department.required' => 'Bagian atau divisi wajib diisi.',

            'bank_name.required' => 'Nama bank wajib diisi.',
            'bank_account_number.required' => 'Nomor rekening wajib diisi.',

            'contract_start.required' => 'Tanggal awal kontrak wajib diisi.',
            'contract_end.required' => 'Tanggal akhir kontrak wajib diisi.',
            'contract_end.after_or_equal' => 'Tanggal akhir kontrak harus sama atau setelah tanggal awal kontrak.',

            'status.required' => 'Status karyawan wajib dipilih.',
            'status.in' => 'Status karyawan tidak valid.',

            'face_photo.required' => 'Foto wajah wajib diunggah.',
            'face_photo.image' => 'Foto wajah harus berupa gambar.',
            'face_photo.mimes' => 'Foto wajah hanya boleh JPG, JPEG, atau PNG.',
            'face_photo.max' => 'Ukuran foto wajah maksimal 2 MB.',

            'ktp_file.required' => 'Dokumen KTP wajib diunggah.',
            'ktp_file.mimes' => 'Dokumen KTP hanya boleh JPG, JPEG, PNG, atau PDF.',
            'ktp_file.max' => 'Ukuran dokumen KTP maksimal 2 MB.',

            'kk_file.required' => 'Dokumen KK wajib diunggah.',
            'kk_file.mimes' => 'Dokumen KK hanya boleh JPG, JPEG, PNG, atau PDF.',
            'kk_file.max' => 'Ukuran dokumen KK maksimal 2 MB.',
        ];
    }
}