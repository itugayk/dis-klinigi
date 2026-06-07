<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        return view('pages.doctors.index', [
            'doctors' => Doctor::active()->with('treatments')->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function show(Doctor $doctor)
    {
        abort_unless($doctor->is_active, 404);

        $doctor->load([
            'treatments' => fn ($q) => $q->active()->orderBy('sort_order'),
            'schedules' => fn ($q) => $q->where('is_active', true),
        ]);

        return view('pages.doctors.show', [
            'doctor' => $doctor,
        ]);
    }
}
