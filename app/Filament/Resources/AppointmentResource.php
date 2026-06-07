<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Randevular';
    protected static ?string $navigationLabel = 'Randevular';
    protected static ?string $modelLabel = 'Randevu';
    protected static ?string $pluralModelLabel = 'Randevular';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', AppointmentStatus::Pending->value)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Randevu')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('doctor_id')
                        ->label('Hekim')->relationship('doctor', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                        ->searchable()->preload()->required(),
                    Forms\Components\Select::make('treatment_id')
                        ->label('Tedavi')->relationship('treatment', 'name')->searchable()->preload(),
                    Forms\Components\DatePicker::make('date')->label('Tarih')->required()->native(false),
                    Forms\Components\Select::make('status')->label('Durum')
                        ->options(AppointmentStatus::options())->default('pending')->required()->native(false),
                    Forms\Components\TimePicker::make('start_time')->label('Başlangıç')->seconds(false)->required(),
                    Forms\Components\TimePicker::make('end_time')->label('Bitiş')->seconds(false)->required(),
                ]),
            Forms\Components\Section::make('Hasta Bilgileri')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('patient_name')->label('Ad Soyad')->required(),
                    Forms\Components\TextInput::make('patient_phone')->label('Telefon')->tel()->required(),
                    Forms\Components\TextInput::make('patient_email')->label('E-posta')->email(),
                    Forms\Components\TextInput::make('appointment_no')->label('Randevu No')
                        ->disabled()->dehydrated(false)->placeholder('Otomatik üretilir'),
                    Forms\Components\Textarea::make('notes')->label('Hasta notu')->rows(2)->columnSpanFull(),
                    Forms\Components\Textarea::make('admin_notes')->label('Klinik notu (dahili)')->rows(2)->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('appointment_no')->label('No')->searchable()->copyable()->size('xs')->color('gray'),
                Tables\Columns\TextColumn::make('patient_name')->label('Hasta')->searchable()->weight('bold')
                    ->description(fn (Appointment $r) => $r->patient_phone),
                Tables\Columns\TextColumn::make('doctor.name')->label('Hekim')
                    ->formatStateUsing(fn (Appointment $r) => $r->doctor?->full_name)->searchable(),
                Tables\Columns\TextColumn::make('treatment.name')->label('Tedavi')->badge()->color('info')->placeholder('Genel'),
                Tables\Columns\TextColumn::make('date')->label('Tarih')->date('d.m.Y')->sortable()
                    ->description(fn (Appointment $r) => $r->time_range),
                Tables\Columns\TextColumn::make('status')->label('Durum')->badge()
                    ->formatStateUsing(fn (AppointmentStatus $state) => $state->label())
                    ->color(fn (AppointmentStatus $state) => $state->color()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options(AppointmentStatus::options()),
                Tables\Filters\SelectFilter::make('doctor_id')->label('Hekim')
                    ->relationship('doctor', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->searchable()->preload(),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Başlangıç')->native(false),
                        Forms\Components\DatePicker::make('until')->label('Bitiş')->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $d) => $q->whereDate('date', '>=', $d))
                            ->when($data['until'] ?? null, fn (Builder $q, $d) => $q->whereDate('date', '<=', $d));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Onayla')->icon('heroicon-m-check-circle')->color('success')
                    ->visible(fn (Appointment $r) => $r->status === AppointmentStatus::Pending)
                    ->requiresConfirmation()
                    ->action(fn (Appointment $r) => $r->update(['status' => AppointmentStatus::Confirmed])),
                Tables\Actions\Action::make('cancel')
                    ->label('İptal')->icon('heroicon-m-x-circle')->color('danger')
                    ->visible(fn (Appointment $r) => in_array($r->status, [AppointmentStatus::Pending, AppointmentStatus::Confirmed]))
                    ->requiresConfirmation()
                    ->action(fn (Appointment $r) => $r->update(['status' => AppointmentStatus::Cancelled])),
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('confirmAll')->label('Seçilenleri onayla')->icon('heroicon-m-check-circle')->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => AppointmentStatus::Confirmed]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Henüz randevu yok')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit'   => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
