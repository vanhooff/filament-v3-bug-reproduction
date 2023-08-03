<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Filament\Forms\Form;

class QuoteForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?array $quoteData = [];


    public function mount(): void
    {
        $this->fillForm();
    }

    public function fillForm(): void
    {
            $this->form->fill(
                [
                    'items' => [
                        [
                            'width' => '',
                            'height' => '',
                            'amount_colors' => 1,
                            'quantity' => 1,
                            'finish' => 'Glans',
                            'request' => '',
                            'file_path' => [],
                        ],
                    ],
                ]
            );
    }

    public function submit()
    {
        dd($this->form->getState());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->columns([
                    'default' => 12,
                    'sm' => 12,
                    'lg' => 12,

                ])
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Bedrijfsnaam')
                            ->autocomplete('organization')
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'lg' => 6,
                            ]),
                        TextInput::make('name')
                            ->label('Volledige naam')
                            ->required()
                            ->autocomplete('name')
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'lg' => 6,
                            ]),
                        TextInput::make('email')
                            ->label('E-mailadres')
                            ->email()
                            ->required()
                            ->autocomplete('email')
                            ->rules(['email:rfc,dns'])
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'lg' => 6,
                            ]),
                        TextInput::make('phone')
                            ->label('Telefoonnummer')
                            ->autocomplete('tel')
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'lg' => 6,
                            ]),
                        Repeater::make('items')
                            ->label('Aanvraag Items')
                            ->required()
                            ->addActionLabel('Extra item toevoegen +')
                            ->schema([
                                Grid::make()->columns([
                                    'default' => 12,
                                    'sm' => 12,
                                    'lg' => 12,

                                ])
                                    ->schema([
                                        TextInput::make('width')
                                            ->label('Breedte')
                                            ->placeholder('100')
                                            ->suffix('cm')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 6,
                                            ]),
                                        TextInput::make('height')
                                            ->label('Hoogte')
                                            ->placeholder('50')
                                            ->suffix('cm')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 6,
                                            ]),
                                        Select::make('amount_colors')
                                            ->label('Aantal kleuren in design')
                                            ->selectablePlaceholder(false)
                                            ->options([
                                                1 => '1',
                                                2 => '2',
                                                3 => '3',
                                                4 => '4',
                                                5 => '5',
                                                6 => '6',
                                                7 => '7',
                                                8 => '8',
                                                9 => '9',
                                                10 => '10',
                                            ])
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 4,
                                            ]),
                                        TextInput::make('quantity')
                                            ->label('Aantal stuks')
                                            ->numeric()
                                            ->placeholder('1')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 4,
                                            ]),
                                        Select::make('finish')
                                            ->label('Gewenste afwerking')
                                            ->selectablePlaceholder(false)
                                            ->options([
                                                'Glans' => 'Glans',
                                                'Mat' => 'Mat',
                                            ])
                                            ->default('Glans')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 4,
                                            ]),
                                        FileUpload::make('file_path')
                                            ->label('Bestanden, voorbeelden, schetsen, screenshots, etc.')
                                            ->acceptedFileTypes([
                                                'image/*',
                                                'application/pdf',
                                                'application/psd',
                                                'application/x-photoshop',
                                                'application/photoshop',
                                                'application/x-eps',
                                                'application/postscript',
                                                'application/illustrator',
                                                'application/vnd.adobe.illustrator',
                                            ])
                                            ->preserveFilenames()
                                            ->multiple()
                                            ->maxFiles(5)
                                            ->panelLayout('compact')
                                            ->imagePreviewHeight('48px')
                                            ->maxSize(20480)
                                            ->directory('user-quote-requests')
                                            ->helperText('Toegestane bestandstypen: .jpg, .png, .heif/heic, .pdf, .eps, .ai, .psd')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 12,
                                            ]),
                                        Textarea::make('request')
                                            ->label('Omschrijf je wensen')
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'lg' => 12,
                                            ]),
                                    ])
                                    ->columnSpan([
                                        'default' => 12,
                                        'sm' => 12,
                                        'lg' => 12,
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'lg' => 12,
                            ])
                            ->minItems(1)
                            ->collapsible()
                            ->cloneable()
                            ->defaultItems(1),

                    ]),
            ])->statePath('quoteData');
    }

    public function render()
    {
        return view('livewire.quote-form');
    }
}
