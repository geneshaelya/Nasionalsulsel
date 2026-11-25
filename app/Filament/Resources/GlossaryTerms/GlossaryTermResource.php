<?php

namespace App\Filament\Resources\GlossaryTerms;

use App\Filament\Resources\GlossaryTerms\Pages\CreateGlossaryTerm;
use App\Filament\Resources\GlossaryTerms\Pages\EditGlossaryTerm;
use App\Filament\Resources\GlossaryTerms\Pages\ListGlossaryTerms;
use App\Models\GlossaryTerm;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class GlossaryTermResource extends Resource
{
    protected static ?string $model = GlossaryTerm::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Kuis & Edukasi';

    protected static ?string $navigationLabel = 'Glosarium Daerah';

    protected static ?string $modelLabel = 'Istilah Daerah';

    protected static ?string $pluralModelLabel = 'Glosarium Bahasa Daerah';

    protected static ?string $recordTitleAttribute = 'istilah';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('istilah')
                    ->required(),
                Select::make('bahasa')
                    ->required()
                    ->options([
                        'Bugis' => 'Bugis',
                        'Makassar' => 'Makassar',
                        'Toraja' => 'Toraja',
                        'Mandar' => 'Mandar',
                    ]),
                TextInput::make('pelafalan')
                    ->placeholder('Contoh: si-ri na pat-ce'),
                Select::make('hero_id')
                    ->label('Terkait Pahlawan')
                    ->relationship('hero', 'nama')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Textarea::make('arti')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('konteks_sejarah')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Terbitkan')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('istilah')
            ->columns([
                TextColumn::make('istilah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bahasa')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pelafalan')
                    ->searchable(),
                TextColumn::make('hero.nama')
                    ->label('Pahlawan')
                    ->placeholder('Umum')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->label('Tayang')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('bahasa')
                    ->options([
                        'Bugis' => 'Bugis',
                        'Makassar' => 'Makassar',
                        'Toraja' => 'Toraja',
                        'Mandar' => 'Mandar',
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
            'index' => ListGlossaryTerms::route('/'),
            'create' => CreateGlossaryTerm::route('/create'),
            'edit' => EditGlossaryTerm::route('/{record}/edit'),
        ];
    }
}
