<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Student Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Profil Personnel')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\FileUpload::make('photo_path')
                                    ->image()
                                    ->directory('students/photos')
                                    ->label('Photo de profil'),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('last_name')
                                            ->required()
                                            ->label('Nom (Majuscules)')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('first_names')
                                            ->required()
                                            ->label('Prénoms')
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('birth_date')
                                            ->required()
                                            ->label('Date de naissance'),
                                        Forms\Components\TextInput::make('birth_place')
                                            ->required()
                                            ->label('Lieu de naissance'),
                                        Forms\Components\TextInput::make('nationality')
                                            ->required()
                                            ->label('Nationalité'),
                                    ]),
                                Forms\Components\Select::make('gender')
                                    ->options([
                                        'M' => 'Homme',
                                        'F' => 'Femme',
                                    ])
                                    ->required()
                                    ->label('Sexe'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Académie')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('filiere_id')
                                            ->relationship('filiere', 'name')
                                            ->required()
                                            ->label('Filière'),
                                        Forms\Components\Select::make('enrollment_level')
                                            ->options([
                                                '1ere annee' => '1ère année',
                                                '2eme annee' => '2ème année',
                                                '3eme annee' => '3ème année',
                                            ])
                                            ->required()
                                            ->label('Niveau d\'inscription'),
                                    ]),
                                Forms\Components\Section::make('Parcours BAC')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('bac_series')
                                                    ->required()
                                                    ->label('Série du BAC'),
                                                Forms\Components\TextInput::make('bac_year')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Année du BAC'),
                                                Forms\Components\TextInput::make('previous_establishment')
                                                    ->required()
                                                    ->label('Établissement de provenance'),
                                            ]),
                                    ]),
                                Forms\Components\Section::make('Documents Numérisés')
                                    ->columns(3)
                                    ->schema([
                                        Forms\Components\FileUpload::make('bac_certificate_path')
                                            ->directory('students/docs')
                                            ->label('Attestation du BAC'),
                                        Forms\Components\FileUpload::make('birth_certificate_path')
                                            ->directory('students/docs')
                                            ->label('Acte de Naissance'),
                                        Forms\Components\FileUpload::make('registration_form_path')
                                            ->directory('students/docs')
                                            ->label('Fiche d\'inscription'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contact')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->required()
                                    ->label('Adresse (Quartier/Ville)'),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->label('Téléphone Étudiant'),
                                Forms\Components\TextInput::make('personal_email')
                                    ->email()
                                    ->required()
                                    ->label('Email Personnel'),
                                Forms\Components\Placeholder::make('academic_email_placeholder')
                                    ->label('Email Académique')
                                    ->content(fn ($record) => $record?->academic_email ?? 'Sera généré automatiquement'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Parent / Tuteur')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Forms\Components\TextInput::make('parent_name')
                                    ->required()
                                    ->label('Nom & Prénoms du Parent'),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('parent_profession')
                                            ->required()
                                            ->label('Profession'),
                                        Forms\Components\TextInput::make('parent_employer')
                                            ->label('Organisme Employeur'),
                                    ]),
                                Forms\Components\TextInput::make('parent_address')
                                    ->required()
                                    ->label('Adresse Parent'),
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('parent_office_phone')
                                            ->tel()
                                            ->label('Tel. Bureau'),
                                        Forms\Components\TextInput::make('parent_home_phone')
                                            ->tel()
                                            ->label('Tel. Domicile'),
                                        Forms\Components\TextInput::make('parent_mobile_phone')
                                            ->tel()
                                            ->required()
                                            ->label('Cellulaire (Mobile)'),
                                    ]),
                                Forms\Components\TextInput::make('parent_email')
                                    ->email()
                                    ->label('Email Parent'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Paiement')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Forms\Components\Select::make('payment_modality')
                                    ->options([
                                        'Comptant' => 'Comptant',
                                        '3 Tranches' => '3 Tranches',
                                        '7 Tranches' => '7 Tranches',
                                    ])
                                    ->required()
                                    ->label('Modalité de Paiement'),
                                Forms\Components\Textarea::make('special_payment_details')
                                    ->label('Détails de paiement spéciaux'),
                                Forms\Components\Select::make('payment_status')
                                    ->options([
                                        'pending' => 'En attente',
                                        'partial' => 'Partiel',
                                        'paid' => 'Réglé',
                                    ])
                                    ->default('pending')
                                    ->label('Statut de Paiement'),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Section::make('Statut Administratif')
                    ->compact()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'actif' => 'Actif',
                                        'suspendu' => 'Suspendu',
                                        'diplome' => 'Diplômé',
                                        'abandon' => 'Abandon',
                                    ])
                                    ->default('actif')
                                    ->required(),
                                Forms\Components\Select::make('registration_status')
                                    ->options([
                                        'en_attente' => 'En attente',
                                        'valide' => 'Validé',
                                        'rejete' => 'Rejeté',
                                    ])
                                    ->default('en_attente')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->circular()
                    ->label(''),
                Tables\Columns\TextColumn::make('matricule')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Matricule'),
                Tables\Columns\TextColumn::make('full_name') // We need to add this property to the model later or use simple concatenation
                    ->label('Nom & Prénoms')
                    ->getStateUsing(fn ($record) => "{$record->last_name} {$record->first_names}")
                    ->searchable(['last_name', 'first_names']),
                Tables\Columns\TextColumn::make('filiere.name')
                    ->badge()
                    ->sortable()
                    ->label('Filière'),
                Tables\Columns\TextColumn::make('enrollment_level')
                    ->label('Niveau'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actif' => 'success',
                        'suspendu' => 'danger',
                        'diplome' => 'info',
                        'abandon' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->label('Paiement'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('filiere')
                    ->relationship('filiere', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'actif' => 'Actif',
                        'suspendu' => 'Suspendu',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStudents::route('/'),
        ];
    }
}