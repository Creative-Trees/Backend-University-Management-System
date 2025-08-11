<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages;
use App\Filament\Resources\FooterResource\RelationManagers;
use App\Models\Footer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;
    protected static ?string $navigationGroup = ' Infrastructure & Support';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Footer Configuration')
                    ->description('Manage website footer information and social media links')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('logo_image')
                                    ->label('Footer Logo')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/footer/logos')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'footer_logo_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->moveFiles()
                                    ->previewable(true)
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\TextInput::make('address')
                                            ->label('University Address')
                                            ->placeholder('Enter university address')
                                            ->prefixIcon('heroicon-o-map-pin')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('contact_email')
                                            ->label('Contact Email')
                                            ->email()
                                            ->placeholder('contact@university.edu')
                                            ->prefixIcon('heroicon-o-envelope')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('whatsapp_number')
                                            ->label('WhatsApp Number')
                                            ->placeholder('+62 123 456 7890')
                                            ->prefixIcon('heroicon-o-phone')
                                            ->maxLength(255),
                                    ])
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Social Media & External Links')
                    ->description('Configure social media and external service links')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->placeholder('https://instagram.com/username')
                                    ->prefixIcon('heroicon-o-camera')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->placeholder('https://youtube.com/channel/...')
                                    ->prefixIcon('heroicon-o-video-camera')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->placeholder('https://linkedin.com/company/...')
                                    ->prefixIcon('heroicon-o-briefcase')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->placeholder('https://facebook.com/page')
                                    ->prefixIcon('heroicon-o-user-group')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('google_maps_url')
                                    ->label('Google Maps URL')
                                    ->url()
                                    ->placeholder('https://maps.google.com/...')
                                    ->prefixIcon('heroicon-o-map')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\ImageColumn::make('logo_image')
                            ->height(50)
                            ->width(80)
                            ->defaultImageUrl(asset('images/default-logo.png'))
                            ->grow(false),

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('address')
                                ->weight('bold')
                                ->color('primary')
                                ->size('sm')
                                ->icon('heroicon-o-map-pin')
                                ->placeholder('Address not set')
                                ->limit(50)
                                ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                    $state = $column->getState();
                                    return strlen($state) > 50 ? $state : null;
                                }),

                            Tables\Columns\TextColumn::make('contact_email')
                                ->color('info')
                                ->size('sm')
                                ->icon('heroicon-o-envelope')
                                ->placeholder('Email not set')
                                ->copyable(),
                        ]),
                    ]),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('whatsapp_number')
                            ->label('WhatsApp')
                            ->color('success')
                            ->size('xs')
                            ->icon('heroicon-o-phone')
                            ->placeholder('Not set'),

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\IconColumn::make('instagram_url')
                                ->boolean()
                                ->trueIcon('heroicon-o-camera')
                                ->falseIcon('')
                                ->trueColor('pink')
                                ->tooltip('Instagram Available')
                                ->getStateUsing(fn ($record) => !empty($record->instagram_url)),

                            Tables\Columns\IconColumn::make('youtube_url')
                                ->boolean()
                                ->trueIcon('heroicon-o-video-camera')
                                ->falseIcon('')
                                ->trueColor('red')
                                ->tooltip('YouTube Available')
                                ->getStateUsing(fn ($record) => !empty($record->youtube_url)),

                            Tables\Columns\IconColumn::make('linkedin_url')
                                ->boolean()
                                ->trueIcon('heroicon-o-briefcase')
                                ->falseIcon('')
                                ->trueColor('blue')
                                ->tooltip('LinkedIn Available')
                                ->getStateUsing(fn ($record) => !empty($record->linkedin_url)),

                            Tables\Columns\IconColumn::make('facebook_url')
                                ->boolean()
                                ->trueIcon('heroicon-o-user-group')
                                ->falseIcon('')
                                ->trueColor('blue')
                                ->tooltip('Facebook Available')
                                ->getStateUsing(fn ($record) => !empty($record->facebook_url)),
                        ])->alignment('end'),
                    ])->from('md'),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('created_at')
                            ->label('Created')
                            ->since()
                            ->color('success')
                            ->size('xs'),

                        Tables\Columns\TextColumn::make('updated_at')
                            ->label('Updated')
                            ->since()
                            ->color('warning')
                            ->size('xs'),
                    ])->from('lg'),
                ])->space(2),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\Filter::make('has_logo')
                    ->label('Has Logo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('logo_image')),

                Tables\Filters\Filter::make('has_social_media')
                    ->label('Has Social Media')
                    ->query(fn (Builder $query): Builder =>
                        $query->where(function ($q) {
                            $q->whereNotNull('instagram_url')
                              ->orWhereNotNull('youtube_url')
                              ->orWhereNotNull('linkedin_url')
                              ->orWhereNotNull('facebook_url');
                        })
                    ),

                Tables\Filters\Filter::make('complete_contact')
                    ->label('Complete Contact Info')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereNotNull('address')
                              ->whereNotNull('contact_email')
                              ->whereNotNull('whatsapp_number')
                    ),

                Tables\Filters\Filter::make('recent')
                    ->label('Recently Updated (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(7))),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver()
                        ->modalWidth('lg'),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Tables\Actions\Action::make('preview_links')
                        ->label('Test Links')
                        ->icon('heroicon-o-link')
                        ->color('info')
                        ->action(function ($record) {
                            // This could open a modal showing all links for testing
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm')
                ->color('gray')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ])
                ->label('Bulk Actions'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Configure Footer')
                    ->icon('heroicon-o-document-text'),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->poll('60s')
            ->searchOnBlur()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();
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
            'index' => Pages\ListFooters::route('/'),
            'create' => Pages\CreateFooter::route('/create'),
            'edit' => Pages\EditFooter::route('/{record}/edit'),
        ];
    }
}
