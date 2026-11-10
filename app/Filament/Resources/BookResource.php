<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Data Buku';

    // Siswa hanya bisa melihat katalog buku, tidak bisa menambah buku baru
    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    // Siswa tidak bisa mengedit data buku
    public static function canEdit(Model $record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    // Siswa tidak bisa menghapus data buku
    public static function canDelete(Model $record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Buku'),

                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255)
                    ->label('Penulis'),

                Forms\Components\TextInput::make('publisher')
                    ->maxLength(255)
                    ->label('Penerbit'),

                Forms\Components\TextInput::make('publication_year')
                    ->label('Tahun Terbit'),

                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255)
                    ->label('ISBN'),

                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->default(1)
                    ->label('Stok'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('publisher')
                    ->label('Penerbit'),

                Tables\Columns\TextColumn::make('publication_year')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN'),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}