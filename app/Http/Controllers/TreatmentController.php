<?php

namespace App\Http\Controllers;

use App\Models\Treatment;

class TreatmentController extends Controller
{
    public function index()
    {
        return view('pages.treatments.index', [
            'treatments' => Treatment::active()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function show(Treatment $treatment)
    {
        abort_unless($treatment->is_active, 404);

        $treatment->load(['doctors' => fn ($q) => $q->active()->orderBy('sort_order')]);

        $jsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalProcedure',
            'name' => $treatment->name,
            'description' => strip_tags((string) ($treatment->excerpt ?: $treatment->description)),
            'procedureType' => 'https://schema.org/SurgicalProcedure',
            'howPerformed' => strip_tags((string) $treatment->description),
            'provider' => [
                '@type' => 'Dentist',
                'name' => site('name'),
                'telephone' => site('contact_phone'),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return view('pages.treatments.show', [
            'treatment' => $treatment,
            'related'   => Treatment::active()->where('id', '!=', $treatment->id)->inRandomOrder()->take(3)->get(),
            'jsonLd'    => $jsonLd,
        ]);
    }
}
