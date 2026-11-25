<?php

namespace App\Filament\Resources\HistoricalSites;

use App\Filament\Resources\HistoricalSites\Pages\CreateHistoricalSite;
use App\Filament\Resources\HistoricalSites\Pages\EditHistoricalSite;
use App\Filament\Resources\HistoricalSites\Pages\ListHistoricalSites;
use App\Models\HistoricalSite;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class HistoricalSiteResource extends Resource
{
    protected static ?string $model = HistoricalSite::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Konten Sejarah';

    protected static ?string $navigationLabel = 'Situs & Makam';

    protected static ?string $modelLabel = 'Situs Sejarah';

    protected static ?string $pluralModelLabel = 'Peta Makam & Situs Sejarah';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Lokasi')
                    ->columns(2)
                    ->schema([
                        Select::make('hero_id')
                            ->label('Tokoh Terkait')
                            ->relationship('hero', 'nama')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('jenis')
                            ->required()
                            ->options([
                                'makam' => 'Makam Pahlawan',
                                'monumen' => 'Monumen Perjuangan',
                                'situs_perjuangan' => 'Situs Sejarah & Benteng',
                                'museum' => 'Museum & Rumah Adat',
                            ])
                            ->default('makam'),
                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, ?HistoricalSite $record) => $record ? null : $set('slug', Str::slug((string) $state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('kabupaten_kota')
                            ->label('Kabupaten / Kota')
                            ->required(),
                        TextInput::make('jam_kunjungan'),
                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Koordinat Peta & Panduan Ziarah')
                    ->columns(2)
                    ->schema([
                        TextInput::make('latitude')
                            ->required()
                            ->numeric()
                            ->step('0.0000001'),
                        TextInput::make('longitude')
                            ->required()
                            ->numeric()
                            ->step('0.0000001'),
                        Textarea::make('info_ziarah')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('akses_navigasi')
                            ->rows(2)
                            ->columnSpanFull(),
                        FileUpload::make('foto_path')
                            ->label('Foto Lokasi')
                            ->disk('public')
                            ->directory('sites')
                            ->image(),
                        Toggle::make('is_published')
                            ->label('Tampilkan di Peta')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hero.nama')
                    ->label('Tokoh')
                    ->searchable()
                    ->placeholder('Umum / Kolektif'),
                TextColumn::make('jenis')
                    ->badge()
                    ->searchable(),
                TextColumn::make('kabupaten_kota')
                    ->label('Kab / Kota')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('latitude')
                    ->numeric(4),
                TextColumn::make('longitude')
                    ->numeric(4),
                IconColumn::make('is_published')
                    ->label('Tayang')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->options([
                        'makam' => 'Makam',
                        'monumen' => 'Monumen',
                        'situs_perjuangan' => 'Situs Perjuangan',
                        'museum' => 'Museum',
                    ]),
            ])
            ->recordActions([
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
            'index' => ListHistoricalSites::route('/'),
            'create' => CreateHistoricalSite::route('/create'),
            'edit' => EditHistoricalSite::route('/{record}/edit'),
        ];
    }
}
