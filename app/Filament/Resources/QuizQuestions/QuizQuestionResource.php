<?php

namespace App\Filament\Resources\QuizQuestions;

use App\Filament\Resources\QuizQuestions\Pages\CreateQuizQuestion;
use App\Filament\Resources\QuizQuestions\Pages\EditQuizQuestion;
use App\Filament\Resources\QuizQuestions\Pages\ListQuizQuestions;
use App\Models\QuizQuestion;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class QuizQuestionResource extends Resource
{
    protected static ?string $model = QuizQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Kuis & Edukasi';

    protected static ?string $navigationLabel = 'Bank Soal Kuis';

    protected static ?string $modelLabel = 'Soal Kuis';

    protected static ?string $pluralModelLabel = 'Bank Soal Kuis';

    protected static ?string $recordTitleAttribute = 'pertanyaan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('quiz_id')
                    ->label('Paket Kuis')
                    ->relationship('quiz', 'judul')
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('pertanyaan')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Repeater::make('opsi')
                    ->label('Pilihan Jawaban (Urut dari Indeks 0)')
                    ->simple(
                        TextInput::make('pilihan')
                            ->required()
                    )
                    ->minItems(2)
                    ->maxItems(5)
                    ->defaultItems(4)
                    ->columnSpanFull(),
                TextInput::make('jawaban_benar')
                    ->label('Indeks Jawaban Benar (0 = pertama, 1 = kedua, dst.)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(4),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('penjelasan')
                    ->label('Penjelasan Jawaban')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pertanyaan')
            ->columns([
                TextColumn::make('quiz.judul')
                    ->label('Kuis')
                    ->searchable()
                    ->sortable()
                    ->limit(35),
                TextColumn::make('pertanyaan')
                    ->searchable()
                    ->limit(55),
                TextColumn::make('jawaban_benar')
                    ->label('Kunci (Idx)')
                    ->numeric(),
                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('quiz_id')
                    ->label('Filter Paket Kuis')
                    ->relationship('quiz', 'judul'),
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
            'index' => ListQuizQuestions::route('/'),
            'create' => CreateQuizQuestion::route('/create'),
            'edit' => EditQuizQuestion::route('/{record}/edit'),
        ];
    }
}
