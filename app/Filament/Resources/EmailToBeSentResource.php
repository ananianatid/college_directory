<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailToBeSentResource\Pages;
use App\Filament\Resources\EmailToBeSentResource\RelationManagers;
use App\Models\EmailToBeSent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailToBeSentResource extends Resource
{
    protected static ?string $model = EmailToBeSent::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Emails à Envoyer';
    protected static ?string $pluralLabel = 'Emails à Envoyer';
    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('recipient_email')
                    ->label('Destinataire (Email)')
                    ->readOnly(),
                Forms\Components\TextInput::make('recipient_name')
                    ->label('Destinataire (Nom)')
                    ->readOnly(),
                Forms\Components\TextInput::make('subject')
                    ->label('Sujet')
                    ->readOnly(),
                Forms\Components\Textarea::make('content')
                    ->label('Contenu')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Créé le')
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recipient_email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Sujet')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmailToBeSents::route('/'),
        ];
    }
}