<?php

namespace App\Filament\Resources\Tp2gdGuides;

use App\Filament\Resources\Tp2gdGuides\Pages\CreateTp2gdGuide;
use App\Filament\Resources\Tp2gdGuides\Pages\EditTp2gdGuide;
use App\Filament\Resources\Tp2gdGuides\Pages\ListTp2gdGuides;
use App\Models\Tp2gdGuide;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class Tp2gdGuideResource extends Resource
{
    protected static ?string $model = Tp2gdGuide::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = 'TP2GD & Moderasi';

    protected static ?string $navigationLabel = 'Alur Pengusulan TP2GD';

    protected static ?string $modelLabel = 'Tahap TP2GD';

    protected static ?string $pluralModelLabel = 'Panduan Alur TP2GD';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahap_nomor')
                    ->label('Tahap Ke-')
                    ->required()
                    ->numeric(),
                TextInput::make('judul')
                    ->required(),
                TextInput::make('instansi_terkait'),
                TextInput::make('estimasi_waktu'),
                Textarea::make('ringkasan')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('deskripsi')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Repeater::make('persyaratan')
                    ->label('Daftar Persyaratan Tahap Ini')
                    ->simple(
                        Textarea::make('syarat')
                            ->rows(2)
                            ->required()
                    )
                    ->defaultItems(0)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tahap_nomor')
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('tahap_nomor')
                    ->label('Tahap')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('judul')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('instansi_terkait')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('estimasi_waktu')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            'index' => ListTp2gdGuides::route('/'),
            'create' => CreateTp2gdGuide::route('/create'),
            'edit' => EditTp2gdGuide::route('/{record}/edit'),
        ];
    }
}
