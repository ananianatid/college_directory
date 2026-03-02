<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiliereResource\Pages;
use App\Filament\Resources\FiliereResource\RelationManagers;
use App\Models\Filiere;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FiliereResource extends Resource
{
    protected static ?string $model = Filiere::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('pole')
                    ->options([
                        'Technologique' => 'Technologique',
                        'Tertiaire' => 'Tertiaire',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pole')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'Technologique' => 'info',
                        'Tertiaire' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pole')
                    ->options([
                        'Technologique' => 'Technologique',
                        'Tertiaire' => 'Tertiaire',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilieres::route('/'),
            'create' => Pages\CreateFiliere::route('/create'),
            'edit' => Pages\EditFiliere::route('/{record}/edit'),
        ];
    }
}