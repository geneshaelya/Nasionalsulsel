<?php

namespace App\Filament\Resources\HeroGalleries;

use App\Filament\Resources\HeroGalleries\Pages\CreateHeroGallery;
use App\Filament\Resources\HeroGalleries\Pages\EditHeroGallery;
use App\Filament\Resources\HeroGalleries\Pages\ListHeroGalleries;
use App\Models\HeroGallery;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class HeroGalleryResource extends Resource
{
    protected static ?string $model = HeroGallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Konten Sejarah';

    protected static ?string $navigationLabel = 'Galeri Arsip';

    protected static ?string $modelLabel = 'Arsip Foto';

    protected static ?string $pluralModelLabel = 'Galeri Arsip Pahlawan';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hero_id')
                    ->label('Pahlawan')
                    ->relationship('hero', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('judul')
                    ->required(),
                FileUpload::make('gambar_path')
                    ->label('Berkas Gambar')
                    ->disk('public')
                    ->directory('galleries')
                    ->image()
                    ->required(),
                TextInput::make('tahun'),
                TextInput::make('sumber'),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                ImageColumn::make('gambar_path')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),
                TextColumn::make('hero.nama')
                    ->label('Pahlawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('tahun')
                    ->searchable(),
                TextColumn::make('sumber')
                    ->searchable(),
                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
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
            'index' => ListHeroGalleries::route('/'),
            'create' => CreateHeroGallery::route('/create'),
            'edit' => EditHeroGallery::route('/{record}/edit'),
        ];
    }
}
