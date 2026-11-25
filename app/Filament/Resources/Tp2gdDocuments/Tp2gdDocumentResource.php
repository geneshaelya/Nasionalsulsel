<?php

namespace App\Filament\Resources\Tp2gdDocuments;

use App\Filament\Resources\Tp2gdDocuments\Pages\CreateTp2gdDocument;
use App\Filament\Resources\Tp2gdDocuments\Pages\EditTp2gdDocument;
use App\Filament\Resources\Tp2gdDocuments\Pages\ListTp2gdDocuments;
use App\Models\Tp2gdDocument;
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
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class Tp2gdDocumentResource extends Resource
{
    protected static ?string $model = Tp2gdDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'TP2GD & Moderasi';

    protected static ?string $navigationLabel = 'Dokumen PDF TP2GD';

    protected static ?string $modelLabel = 'Dokumen TP2GD';

    protected static ?string $pluralModelLabel = 'Dokumen PDF Pengusulan TP2GD';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->required(),
                Select::make('kategori')
                    ->required()
                    ->options([
                        'panduan' => 'Panduan',
                        'formulir' => 'Formulir / Checklist',
                        'template' => 'Templat Naskah',
                        'regulasi' => 'Regulasi',
                    ])
                    ->default('panduan'),
                Textarea::make('deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('file_path')
                    ->label('Berkas PDF')
                    ->disk('public')
                    ->directory('tp2gd')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->openable()
                    ->required(),
                TextInput::make('ukuran_kb')
                    ->label('Ukuran (KB)')
                    ->numeric(),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('kategori')
                    ->badge()
                    ->searchable(),
                TextColumn::make('ukuran_kb')
                    ->label('Ukuran')
                    ->suffix(' KB')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
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
            'index' => ListTp2gdDocuments::route('/'),
            'create' => CreateTp2gdDocument::route('/create'),
            'edit' => EditTp2gdDocument::route('/{record}/edit'),
        ];
    }
}
