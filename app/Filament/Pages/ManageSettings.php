<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Klinik Ayarları';
    protected static ?string $navigationLabel = 'Site Ayarları';
    protected static ?string $title = 'Site Ayarları';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $social = site('social', []);

        $this->form->fill([
            'name'                 => site('name'),
            'short_name'           => site('short_name'),
            'tagline'              => site('tagline'),
            'description'          => site('description'),
            'contact_phone'        => site('contact_phone'),
            'contact_phone_e164'   => site('contact_phone_e164'),
            'whatsapp'             => site('whatsapp'),
            'contact_email'        => site('contact_email'),
            'address'              => site('address'),
            'map_embed'            => site('map_embed'),
            'social_instagram'     => $social['instagram'] ?? '',
            'social_facebook'      => $social['facebook'] ?? '',
            'social_youtube'       => $social['youtube'] ?? '',
            'social_x'             => $social['x'] ?? '',
            'working_hours'        => site('working_hours', []),
            'holidays'             => site('holidays', []),
            'slot_minutes'         => (int) site('slot_minutes', 30),
            'booking_horizon_days' => (int) site('booking_horizon_days', 30),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()->tabs([
                    Forms\Components\Tabs\Tab::make('Genel')->icon('heroicon-m-building-storefront')->schema([
                        Forms\Components\TextInput::make('name')->label('Klinik adı')->required(),
                        Forms\Components\TextInput::make('short_name')->label('Kısa ad')->required(),
                        Forms\Components\TextInput::make('tagline')->label('Slogan'),
                        Forms\Components\Textarea::make('description')->label('Açıklama')->rows(3),
                    ])->columns(2),

                    Forms\Components\Tabs\Tab::make('İletişim')->icon('heroicon-m-phone')->schema([
                        Forms\Components\TextInput::make('contact_phone')->label('Telefon (görünen)'),
                        Forms\Components\TextInput::make('contact_phone_e164')->label('Telefon (tel: linki)')
                            ->helperText('Örn: +902125550100'),
                        Forms\Components\TextInput::make('whatsapp')->label('WhatsApp no')->helperText('Örn: +905555550100'),
                        Forms\Components\TextInput::make('contact_email')->label('E-posta')->email()
                            ->helperText('Randevu bildirimleri bu adrese gider.'),
                        Forms\Components\TextInput::make('address')->label('Adres')->columnSpanFull(),
                        Forms\Components\Textarea::make('map_embed')->label('Google Harita embed URL')->rows(2)->columnSpanFull(),
                    ])->columns(2),

                    Forms\Components\Tabs\Tab::make('Sosyal Medya')->icon('heroicon-m-share')->schema([
                        Forms\Components\TextInput::make('social_instagram')->label('Instagram')->url()->prefixIcon('heroicon-m-camera'),
                        Forms\Components\TextInput::make('social_facebook')->label('Facebook')->url(),
                        Forms\Components\TextInput::make('social_youtube')->label('YouTube')->url(),
                        Forms\Components\TextInput::make('social_x')->label('X (Twitter)')->url(),
                    ])->columns(2),

                    Forms\Components\Tabs\Tab::make('Çalışma Saatleri & Tatiller')->icon('heroicon-m-clock')->schema([
                        Forms\Components\KeyValue::make('working_hours')
                            ->label('Çalışma saatleri (vitrin)')
                            ->keyLabel('Gün(ler)')->valueLabel('Saat')
                            ->addActionLabel('Satır ekle')->columnSpanFull(),
                        Forms\Components\Repeater::make('holidays')
                            ->label('Resmi tatil / kapalı günler')
                            ->simple(Forms\Components\DatePicker::make('date')->native(false)->required())
                            ->addActionLabel('Tatil günü ekle')
                            ->helperText('Bu günlerde tüm hekimlere randevu kapanır.')
                            ->columnSpanFull(),
                    ]),

                    Forms\Components\Tabs\Tab::make('Randevu')->icon('heroicon-m-calendar')->schema([
                        Forms\Components\TextInput::make('slot_minutes')->label('Slot aralığı (dakika)')
                            ->numeric()->required()->helperText('Randevu saat aralığı granülasyonu.'),
                        Forms\Components\TextInput::make('booking_horizon_days')->label('Randevu ufku (gün)')
                            ->numeric()->required()->helperText('Kaç gün ileriye randevu açılır.'),
                    ])->columns(2),
                ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::putMany([
            'name'                 => $state['name'],
            'short_name'           => $state['short_name'],
            'tagline'              => $state['tagline'],
            'description'          => $state['description'],
            'contact_phone'        => $state['contact_phone'],
            'contact_phone_e164'   => $state['contact_phone_e164'],
            'whatsapp'             => $state['whatsapp'],
            'contact_email'        => $state['contact_email'],
            'address'              => $state['address'],
            'map_embed'            => $state['map_embed'],
            'social'               => array_filter([
                'instagram' => $state['social_instagram'] ?? null,
                'facebook'  => $state['social_facebook'] ?? null,
                'youtube'   => $state['social_youtube'] ?? null,
                'x'         => $state['social_x'] ?? null,
            ]),
            'working_hours'        => $state['working_hours'] ?? [],
            'holidays'             => array_values(array_filter($state['holidays'] ?? [])),
            'slot_minutes'         => (int) $state['slot_minutes'],
            'booking_horizon_days' => (int) $state['booking_horizon_days'],
        ]);

        Notification::make()->title('Ayarlar kaydedildi')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Kaydet')->submit('save'),
        ];
    }
}
