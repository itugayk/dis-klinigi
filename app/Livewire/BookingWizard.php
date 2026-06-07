<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentReceived;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookingWizard extends Component
{
    public int $step = 1;

    public ?int $treatmentId = null;
    public ?int $doctorId = null;
    public ?string $date = null;        // YYYY-MM-DD
    public ?string $startTime = null;   // HH:MM

    public string $patientName = '';
    public string $patientPhone = '';
    public string $patientEmail = '';
    public string $notes = '';
    public bool $kvkk = false;

    public string $month;               // takvim: ayın ilk günü YYYY-MM-DD
    public array $bookableDates = [];   // seçili hekim için uygun günler

    public ?string $confirmationNo = null;

    public function mount(?int $treatment = null, ?int $doctor = null): void
    {
        // Route segmenti gelmezse query string'ten oku (?treatment=, ?doctor=)
        $treatment ??= request()->integer('treatment') ?: null;
        $doctor ??= request()->integer('doctor') ?: null;

        $this->month = today()->startOfMonth()->toDateString();

        if ($treatment && Treatment::active()->whereKey($treatment)->exists()) {
            $this->treatmentId = $treatment;
            $this->step = 2;
        }
        if ($doctor && Doctor::bookable()->whereKey($doctor)->exists()) {
            $this->doctorId = $doctor;
            $this->refreshBookableDates();
            $this->step = $this->treatmentId ? 3 : 2;
        }
    }

    protected function slots(): SlotService
    {
        return app(SlotService::class);
    }

    /* ----------------------------------------------------------- Computed */

    #[Computed]
    public function treatments()
    {
        return Treatment::active()->orderBy('sort_order')->orderBy('name')->get();
    }

    #[Computed]
    public function doctors()
    {
        return Doctor::bookable()
            ->when($this->treatmentId, fn ($q) => $q->whereHas(
                'treatments',
                fn ($t) => $t->whereKey($this->treatmentId)
            ))
            ->orderBy('sort_order')->orderBy('name')
            ->get();
    }

    #[Computed]
    public function selectedTreatment(): ?Treatment
    {
        return $this->treatmentId ? Treatment::find($this->treatmentId) : null;
    }

    #[Computed]
    public function selectedDoctor(): ?Doctor
    {
        return $this->doctorId ? Doctor::find($this->doctorId) : null;
    }

    #[Computed]
    public function timeSlots(): array
    {
        if (! $this->doctorId || ! $this->date) {
            return [];
        }

        return $this->slots()->availableSlots(
            $this->selectedDoctor,
            Carbon::parse($this->date),
            $this->selectedTreatment,
        );
    }

    /** Takvim ızgarası: [ ['date'=>..,'day'=>..,'inMonth'=>bool,'bookable'=>bool,'past'=>bool], ... ] */
    #[Computed]
    public function calendar(): array
    {
        $first = Carbon::parse($this->month)->startOfMonth();
        $start = $first->copy()->startOfWeek(Carbon::MONDAY);
        $end   = $first->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $ds = $cursor->toDateString();
            $days[] = [
                'date'     => $ds,
                'day'      => $cursor->day,
                'inMonth'  => $cursor->month === $first->month,
                'past'     => $cursor->lt(today()),
                'bookable' => in_array($ds, $this->bookableDates, true),
            ];
            $cursor->addDay();
        }

        return $days;
    }

    public function getMonthLabelProperty(): string
    {
        return Carbon::parse($this->month)->translatedFormat('F Y');
    }

    public function getCanGoPrevMonthProperty(): bool
    {
        return Carbon::parse($this->month)->gt(today()->startOfMonth());
    }

    public function getCanGoNextMonthProperty(): bool
    {
        $horizonEnd = today()->addDays($this->slots()->horizonDays());

        return Carbon::parse($this->month)->endOfMonth()->lt($horizonEnd);
    }

    /* ------------------------------------------------------------- Actions */

    public function selectTreatment(int $id): void
    {
        $this->treatmentId = $id;
        // tedavi değişince hekim/slot sıfırla
        $this->reset(['doctorId', 'date', 'startTime', 'bookableDates']);
        $this->step = 2;
    }

    public function skipTreatment(): void
    {
        $this->treatmentId = null;
        $this->reset(['doctorId', 'date', 'startTime', 'bookableDates']);
        $this->step = 2;
    }

    public function selectDoctor(int $id): void
    {
        $this->doctorId = $id;
        $this->reset(['date', 'startTime']);
        $this->month = today()->startOfMonth()->toDateString();
        $this->refreshBookableDates();
        $this->step = 3;
    }

    protected function refreshBookableDates(): void
    {
        if ($this->doctorId && $this->selectedDoctor) {
            $this->bookableDates = $this->slots()
                ->availableDates($this->selectedDoctor, $this->selectedTreatment)
                ->all();
        }
    }

    public function selectDate(string $date): void
    {
        if (! in_array($date, $this->bookableDates, true)) {
            return;
        }
        $this->date = $date;
        $this->startTime = null;
        $this->step = 4;
    }

    public function selectSlot(string $start): void
    {
        $this->startTime = $start;
        $this->step = 5;
    }

    public function prevMonth(): void
    {
        if ($this->canGoPrevMonth) {
            $this->month = Carbon::parse($this->month)->subMonth()->startOfMonth()->toDateString();
        }
    }

    public function nextMonth(): void
    {
        if ($this->canGoNextMonth) {
            $this->month = Carbon::parse($this->month)->addMonth()->startOfMonth()->toDateString();
        }
    }

    public function goToStep(int $step): void
    {
        // sadece geriye / tamamlanmış adımlara izin ver
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function submit(): void
    {
        $this->validate([
            'patientName'  => ['required', 'string', 'min:3', 'max:120'],
            'patientPhone' => ['required', 'string', 'min:7', 'max:30'],
            'patientEmail' => ['nullable', 'email', 'max:160'],
            'notes'        => ['nullable', 'string', 'max:1000'],
            'kvkk'         => ['accepted'],
            'doctorId'     => ['required', Rule::exists('doctors', 'id')],
            'date'         => ['required', 'date'],
            'startTime'    => ['required'],
        ], attributes: [
            'patientName'  => 'ad soyad',
            'patientPhone' => 'telefon',
            'patientEmail' => 'e-posta',
            'kvkk'         => 'KVKK onayı',
        ]);

        $doctor = $this->selectedDoctor;
        $treatment = $this->selectedTreatment;

        // Kayıt öncesi son slot kontrolü (yarış koşulu)
        if (! $this->slots()->isSlotAvailable($doctor, Carbon::parse($this->date), $this->startTime, $treatment)) {
            $this->refreshBookableDates();
            $this->reset(['startTime']);
            $this->step = 4;
            $this->addError('startTime', 'Seçtiğiniz saat az önce doldu. Lütfen başka bir saat seçin.');

            return;
        }

        $duration = $treatment?->duration_minutes ?: $this->slots()->slotMinutes();
        $end = Carbon::parse($this->date.' '.$this->startTime)->addMinutes($duration)->format('H:i');

        try {
            $appointment = Appointment::create([
                'treatment_id'  => $this->treatmentId,
                'doctor_id'     => $doctor->id,
                'patient_name'  => $this->patientName,
                'patient_phone' => $this->patientPhone,
                'patient_email' => $this->patientEmail ?: null,
                'date'          => $this->date,
                'start_time'    => $this->startTime,
                'end_time'      => $end,
                'status'        => AppointmentStatus::Pending,
                'notes'         => $this->notes ?: null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // unique(doctor,date,start) ihlali → slot kapıldı
            $this->refreshBookableDates();
            $this->reset(['startTime']);
            $this->step = 4;
            $this->addError('startTime', 'Seçtiğiniz saat az önce doldu. Lütfen başka bir saat seçin.');

            return;
        }

        // Bildirim e-postaları (MAIL_MAILER=log → log'a yazılır)
        try {
            if ($appointment->patient_email) {
                Mail::to($appointment->patient_email)->send(new AppointmentReceived($appointment));
            }
            if ($clinic = site('contact_email')) {
                Mail::to($clinic)->send(new AppointmentReceived($appointment));
            }
        } catch (\Throwable $e) {
            report($e); // mail hatası randevuyu bozmasın
        }

        $this->confirmationNo = $appointment->appointment_no;
        $this->step = 6;
    }

    public function resetWizard(): void
    {
        $this->reset();
        $this->month = today()->startOfMonth()->toDateString();
        $this->step = 1;
    }

    public function render()
    {
        return view('livewire.booking-wizard')->layout('components.layouts.app', [
            'title'       => 'Online Randevu Al',
            'description' => 'Dentila Diş Polikliniği online randevu sistemi ile birkaç adımda kolayca randevunuzu oluşturun.',
        ]);
    }
}
