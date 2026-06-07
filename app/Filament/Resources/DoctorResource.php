<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Hekimler';
    protected static ?string $modelLabel = 'Hekim';
    protected static ?string $pluralModelLabel = 'Hekimler';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Hekim Bilgileri')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Ünvan')->default('Dt.')->maxLength(50)
                        ->datalist(['Dt.', 'Dr. Dt.', 'Uzm. Dt.', 'Doç. Dr.', 'Prof. Dr.']),
                    Forms\Components\TextInput::make('name')->label('Ad Soyad')->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    Forms\Components\TextInput::make('slug')->label('URL (slug)')->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('specialty')->label('Ana uzmanlık')->required()
                        ->placeholder('İmplantoloji'),
                    Forms\Components\TagsInput::make('specialties')->label('Diğer uzmanlıklar')->columnSpanFull(),
                    Forms\Components\Textarea::make('bio')->label('Hakkında')->rows(5)->columnSpanFull(),
                    Forms\Components\TextInput::make('photo_url')->label('Fotoğraf URL')->url()->columnSpanFull(),
                ]),
            Forms\Components\Section::make('İletişim & Ayarlar')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('email')->label('E-posta')->email(),
                    Forms\Components\TextInput::make('phone')->label('Telefon')->tel(),
                    Forms\Components\TextInput::make('experience_years')->label('Deneyim (yıl)')->numeric(),
                    Forms\Components\Select::make('treatments')
                        ->label('Uyguladığı tedaviler')
                        ->relationship('treatments', 'name')
                        ->multiple()->preload()->columnSpanFull()
                        ->helperText('Randevu sihirbazında hekim bu tedavilerde listelenir.'),
                    Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                    Forms\Components\Toggle::make('accepts_appointments')->label('Randevu kabul eder')->default(true)->inline(false),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)->inline(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')->label('')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Hekim')->searchable()
                    ->formatStateUsing(fn (Doctor $r) => $r->full_name)->weight('bold'),
                Tables\Columns\TextColumn::make('specialty')->label('Uzmanlık')->badge()->color('info'),
                Tables\Columns\TextColumn::make('appointments_count')->label('Randevu')->counts('appointments')->badge(),
                Tables\Columns\IconColumn::make('accepts_appointments')->label('Randevu')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SchedulesRelationManager::class,
            RelationManagers\TimeOffRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit'   => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
