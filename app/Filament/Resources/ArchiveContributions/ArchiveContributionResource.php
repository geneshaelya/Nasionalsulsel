<?php

namespace App\Filament\Resources\ArchiveContributions;

use App\Filament\Resources\ArchiveContributions\Pages\CreateArchiveContribution;
use App\Filament\Resources\ArchiveContributions\Pages\EditArchiveContribution;
use App\Filament\Resources\ArchiveContributions\Pages\ListArchiveContributions;
use App\Models\ArchiveContribution;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class ArchiveContributionResource extends Resource
{
    protected static ?string $model = ArchiveContribution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'TP2GD & Moderasi';

    protected static ?string $navigationLabel = 'Kontribusi Arsip';

    protected static ?string $modelLabel = 'Kontribusi Arsip';

    protected static ?string $pluralModelLabel = 'Moderasi Kontribusi Arsip Publik';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function getNavigationBadge(): ?string
    {
        $draftCount = static::getModel()::query()->where('status', 'draft')->count();

        return $draftCount > 0 ? (string) $draftCount : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pengirim & Kontribusi')
                    ->columns(2)
                    ->schema([
                        Select::make('hero_id')
                            ->label('Tokoh Terkait')
                            ->relationship('hero', 'nama')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('jenis_kontribusi')
                            ->required()
                            ->options([
                                'foto_arsip' => 'Foto Arsip / Dokumentasi',
                                'catatan_sejarah' => 'Catatan Sejarah',
                                'dokumen_keluarga' => 'Dokumen / Surat Keluarga',
                            ])
                            ->default('catatan_sejarah'),
                        TextInput::make('nama_pengirim')
                            ->required(),
                        TextInput::make('hubungan_tokoh')
                            ->label('Hubungan dengan Tokoh'),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('telepon')
                            ->tel(),
                        TextInput::make('judul')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('isi_catatan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('file_path')
                            ->label('Lampiran Dokumen / Foto')
                            ->disk('public')
                            ->directory('contributions')
                            ->openable()
                            ->downloadable(),
                        TextInput::make('sumber_dokumen'),
                    ]),

                Section::make('Moderasi & Verifikasi Dinsos')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->required()
                            ->options([
                                'draft' => 'Draft (Menunggu Verifikasi)',
                                'published' => 'Terverifikasi & Tayang',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('draft'),
                        DateTimePicker::make('verified_at')
                            ->label('Waktu Verifikasi'),
                        Textarea::make('catatan_admin')
                            ->label('Catatan Verifikator Dinsos')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->limit(36),
                TextColumn::make('hero.nama')
                    ->label('Tokoh')
                    ->placeholder('Umum / Tokoh Baru')
                    ->searchable(),
                TextColumn::make('nama_pengirim')
                    ->searchable(),
                TextColumn::make('jenis_kontribusi')
                    ->label('Jenis')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'published', 'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'published', 'approved' => 'Tayang',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Menunggu Verifikasi (Draft)',
                        'published' => 'Tayang',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Verifikasi & Tayangkan')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (ArchiveContribution $record): bool => $record->status === 'draft')
                    ->action(function (ArchiveContribution $record): void {
                        $record->update([
                            'status' => 'published',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (ArchiveContribution $record): bool => $record->status === 'draft')
                    ->action(function (ArchiveContribution $record): void {
                        $record->update([
                            'status' => 'rejected',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArchiveContributions::route('/'),
            'create' => CreateArchiveContribution::route('/create'),
            'edit' => EditArchiveContribution::route('/{record}/edit'),
        ];
    }
}
