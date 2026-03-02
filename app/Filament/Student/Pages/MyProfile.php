<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class MyProfile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Mon Profil';
    protected static ?string $title = 'Mon Profil';
    protected static ?string $slug = 'mon-profil';
    protected static string $view = 'filament.student.pages.my-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $student = Auth::user()->student;

        if (!$student) {
            abort(403);
        }

        $this->form->fill($student->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Détails du Profil')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informations Personnelles')
                            ->schema([
                                Forms\Components\FileUpload::make('photo_path')
                                    ->image()
                                    ->directory('students/photos')
                                    ->label('Photo de profil'), 
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('last_name')
                                            ->label('Nom')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('first_names')
                                            ->label('Prénoms')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('matricule')
                                            ->label('Matricule')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('academic_email')
                                            ->label('Email Académique')
                                            ->readOnly(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Académie')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('filiere_name')
                                            ->label('Filière')
                                            ->placeholder(fn () => Auth::user()->student?->filiere?->name)
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('enrollment_level')
                                            ->label('Niveau d\'inscription')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('bac_series')
                                            ->label('Série du BAC')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('bac_year')
                                            ->label('Année du BAC')
                                            ->readOnly(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contact')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Téléphone')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('personal_email')
                                            ->label('Email Personnel')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('address')
                                            ->label('Adresse')
                                            ->readOnly(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Parent / Tuteur')
                            ->schema([
                                Forms\Components\TextInput::make('parent_name')
                                    ->label('Nom du Parent')
                                    ->readOnly(),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('parent_mobile_phone')
                                            ->label('Mobile Parent')
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('parent_email')
                                            ->label('Email Parent')
                                            ->readOnly(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $student = Auth::user()->student;

        $student->update([
            'photo_path' => $data['photo_path'] ?? $student->photo_path,
        ]);

        Notification::make()
            ->title('Photo mise à jour')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Enregistrer la photo')
                ->submit('save'),
        ];
    }
}
