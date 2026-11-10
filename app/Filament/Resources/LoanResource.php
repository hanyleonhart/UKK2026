<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Peminjaman Buku';

    // Hak Akses 1: Baik Siswa maupun Admin bisa membuat peminjaman baru
    public static function canCreate(): bool
    {
        return auth()->check();
    }

    // Hak Akses 2: Hanya Admin yang bisa mengedit transaksi (misal: update status ke 'Dikembalikan')
    public static function canEdit(Model $record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    // Hak Akses 3: Hanya Admin yang bisa menghapus data peminjaman
    public static function canDelete(Model $record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    // Siswa hanya melihat transaksi miliknya sendiri, Admin melihat semua transaksi
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check() && auth()->user()->role === 'siswa') {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(fn () => auth()->id())
                    ->disabled(fn () => auth()->check() && auth()->user()->role === 'siswa')
                    ->dehydrated()
                    ->required()
                    ->label('Nama Peminjam'),

                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->required()
                    ->label('Judul Buku'),

                Forms\Components\DatePicker::make('loan_date')
                    ->default(now())
                    ->required()
                    ->label('Tanggal Pinjam'),

                Forms\Components\DatePicker::make('return_date')
                    ->default(now()->addDays(7))
                    ->required()
                    ->label('Tenggat Pengembalian'),

                Forms\Components\DatePicker::make('actual_return_date')
                    ->label('Tanggal Dikembalikan (Real)'),

                Forms\Components\Select::make('status')
                    ->options([
                        'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                    ])
                    ->default('borrowed')
                    ->required()
                    ->label('Status Peminjaman'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('book.title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('loan_date')
                    ->date()
                    ->label('Tgl Pinjam')
                    ->sortable(),

                Tables\Columns\TextColumn::make('return_date')
                    ->date()
                    ->label('Tenggat Kembali')
                    ->sortable(),

                Tables\Columns\TextColumn::make('actual_return_date')
                    ->date()
                    ->label('Tgl Dikembalikan')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrowed' => 'warning',
                        'returned' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                    ]),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}