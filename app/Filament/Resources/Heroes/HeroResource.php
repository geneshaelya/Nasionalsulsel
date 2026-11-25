<?php

namespace App\Filament\Resources\Heroes;

use App\Filament\Resources\Heroes\Pages\CreateHero;
use App\Filament\Resources\Heroes\Pages\EditHero;
use App\Filament\Resources\Heroes\Pages\ListHeroes;
use App\Models\Hero;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Konten Sejarah';

    protected static ?string $navigationLabel = 'Pahlawan';

    protected static ?string $modelLabel = 'Pahlawan';

    protected static ?string $pluralModelLabel = 'Data Pahlawan';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas & Gelar Tokoh')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, ?Hero $record) => $record ? null : $set('slug', Str::slug((string) $state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('gelar_singkat')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('kategori')
                            ->required()
                            ->options([
                                'nasional' => 'Pahlawan Nasional',
                                'daerah' => 'Pahlawan Daerah Sulsel',
                                'calon' => 'Calon Pahlawan Nasional (TP2GD)',
                            ])
                            ->default('nasional'),
                        TextInput::make('asal_daerah')
                            ->required(),
                        TextInput::make('tempat_lahir'),
                        TextInput::make('tanggal_lahir'),
                        TextInput::make('tempat_wafat'),
                        TextInput::make('tanggal_wafat'),
                        TextInput::make('tahun_penanda')
                            ->label('Tahun Penanda Linimasa')
                            ->required()
                            ->numeric(),
                        TextInput::make('label_penanda')
                            ->label('Keterangan Penanda Tahun'),
                        TextInput::make('keppres_nomor')
                            ->label('Nomor Keppres'),
                        TextInput::make('tanggal_penetapan')
                            ->label('Tanggal Penetapan'),
                        TextInput::make('masa_jabatan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Biografi, Riwayat & Fakta Sejarah')
                    ->schema([
                        Textarea::make('ringkasan')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('biografi')
                            ->rows(5)
                            ->columnSpanFull(),
                        Repeater::make('riwayat_hidup')
                            ->label('Paragraf Riwayat Hidup')
                            ->simple(
                                Textarea::make('paragraf')
                                    ->rows(2)
                                    ->required()
                            )
                            ->defaultItems(0)
                            ->columnSpanFull(),
                        Repeater::make('perjuangan_jasa')
                            ->label('Poin Perjuangan & Jasa')
                            ->simple(
                                TextInput::make('poin')
                                    ->required()
                            )
                            ->defaultItems(0)
                            ->columnSpanFull(),
                        Textarea::make('hubungan_keluarga')
                            ->rows(2)
                            ->columnSpanFull(),
                        Repeater::make('fun_facts')
                            ->label('Fakta Menarik (Fun Facts)')
                            ->schema([
                                TextInput::make('judul')->required(),
                                Textarea::make('fakta')->rows(2)->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                        Repeater::make('sumber_referensi')
                            ->label('Sumber Referensi')
                            ->schema([
                                TextInput::make('judul')->required(),
                                TextInput::make('url')->url()->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                Section::make('Tampilan & Media')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('foto_utama')
                            ->label('Foto Potret Pahlawan')
                            ->disk('public')
                            ->directory('heroes')
                            ->image()
                            ->imageEditor(),
                        ColorPicker::make('warna_aksen')
                            ->label('Warna Aksen Halaman')
                            ->required()
                            ->default('#33291a'),
                        TextInput::make('ukuran_strip')
                            ->label('Ukuran di Strip Beranda (24–48)')
                            ->required()
                            ->numeric()
                            ->default(34),
                        TextInput::make('urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Terbitkan di Portal Publik')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->recordTitleAttribute('nama')
            ->columns([
                ImageColumn::make('foto_utama')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Hero $record): string => $record->gelar_singkat),
                TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'nasional' => 'success',
                        'daerah' => 'warning',
                        'calon' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'nasional' => 'Nasional',
                        'daerah' => 'Daerah',
                        'calon' => 'Calon TP2GD',
                        default => $state,
                    }),
                TextColumn::make('asal_daerah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tahun_penanda')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Tayang')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'nasional' => 'Pahlawan Nasional',
                        'daerah' => 'Pahlawan Daerah',
                        'calon' => 'Calon TP2GD',
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
            'index' => ListHeroes::route('/'),
            'create' => CreateHero::route('/create'),
            'edit' => EditHero::route('/{record}/edit'),
        ];
    }
}
