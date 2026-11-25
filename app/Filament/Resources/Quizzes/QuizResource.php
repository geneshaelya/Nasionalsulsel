<?php

namespace App\Filament\Resources\Quizzes;

use App\Filament\Resources\Quizzes\Pages\CreateQuiz;
use App\Filament\Resources\Quizzes\Pages\EditQuiz;
use App\Filament\Resources\Quizzes\Pages\ListQuizzes;
use App\Models\Quiz;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
use Illuminate\Support\Str;
use UnitEnum;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Kuis & Edukasi';

    protected static ?string $navigationLabel = 'Paket Kuis';

    protected static ?string $modelLabel = 'Kuis';

    protected static ?string $pluralModelLabel = 'Paket Kuis Interaktif';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hero_id')
                    ->label('Pahlawan (Kosongkan untuk Kuis Umum)')
                    ->relationship('hero', 'nama')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set, ?Quiz $record) => $record ? null : $set('slug', Str::slug((string) $state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('durasi_menit')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('passing_score')
                    ->label('Nilai Minimal Lulus (%)')
                    ->required()
                    ->numeric()
                    ->default(70),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hero.nama')
                    ->label('Cakupan')
                    ->placeholder('Kuis Umum Keseluruhan')
                    ->searchable(),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Jumlah Soal')
                    ->sortable(),
                TextColumn::make('passing_score')
                    ->label('KKM (%)')
                    ->numeric(),
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
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'edit' => EditQuiz::route('/{record}/edit'),
        ];
    }
}
