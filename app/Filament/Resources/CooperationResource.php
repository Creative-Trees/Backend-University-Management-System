<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CooperationResource\Pages;
use App\Filament\Resources\CooperationResource\RelationManagers;
use App\Models\Cooperation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CooperationResource extends Resource
{
    protected static ?string $model = Cooperation::class;
    protected static ?string $navigationGroup = 'Collaboration & External Relations';

    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Partnership Information')
                    ->description('Manage university partnerships and collaboration details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Partner Logo')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                                    ->directory('uploads/cooperation/logos')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'partner_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->moveFiles()
                                    ->previewable(true)
                                    ->openable()
                                    ->downloadable()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\TextInput::make('partner_name')
                                            ->label('Partner Name')
                                            ->placeholder('Enter partner organization name')
                                            ->prefixIcon('heroicon-o-building-office')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('url')
                                            ->label('Partner Website URL')
                                            ->required()
                                            ->url()
                                            ->placeholder('https://example.com')
                                            ->prefixIcon('heroicon-o-globe-alt')
                                            ->maxLength(255),

                                        Forms\Components\Select::make('cooperation_type')
                                            ->label('Cooperation Type')
                                            ->options([
                                                'academic' => 'Academic Collaboration',
                                                'research' => 'Research Partnership',
                                                'industry' => 'Industry Partnership',
                                                'government' => 'Government Collaboration',
                                                'international' => 'International Partnership',
                                                'ngo' => 'NGO Partnership',
                                            ])
                                            ->prefixIcon('heroicon-o-user-group')
                                            ->placeholder('Select cooperation type'),

                                        Forms\Components\Select::make('status')
                                            ->label('Partnership Status')
                                            ->options([
                                                'active' => 'Active',
                                                'pending' => 'Pending',
                                                'expired' => 'Expired',
                                                'suspended' => 'Suspended',
                                            ])
                                            ->default('active')
                                            ->prefixIcon('heroicon-o-flag'),
                                    ])
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Partnership Start Date')
                                    ->prefixIcon('heroicon-o-calendar'),

                                Forms\Components\DatePicker::make('end_date')
                                    ->label('Partnership End Date')
                                    ->prefixIcon('heroicon-o-calendar')
                                    ->after('start_date'),
                            ]),

                        Forms\Components\RichEditor::make('description')
                            ->label('Partnership Description')
                            ->placeholder('Describe the partnership and collaboration details...')
                            ->columnSpanFull(),
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
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height(60)
                        ->width(60)
                        ->circular()
                        ->defaultImageUrl(asset('images/default-partner.png'))
                        ->grow(false),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('partner_name')
                            ->weight('bold')
                            ->color('primary')
                            ->size('lg')
                            ->placeholder('Partner Name Not Set')
                            ->searchable()
                            ->sortable(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\BadgeColumn::make('cooperation_type')
                                ->label('Type')
                                ->colors([
                                    'primary' => 'academic',
                                    'success' => 'research',
                                    'warning' => 'industry',
                                    'info' => 'government',
                                    'purple' => 'international',
                                    'gray' => 'ngo',
                                ])
                                ->icons([
                                    'heroicon-o-academic-cap' => 'academic',
                                    'heroicon-o-beaker' => 'research',
                                    'heroicon-o-building-office' => 'industry',
                                    'heroicon-o-building-library' => 'government',
                                    'heroicon-o-globe-alt' => 'international',
                                    'heroicon-o-heart' => 'ngo',
                                ])
                                ->size('sm'),

                            Tables\Columns\BadgeColumn::make('status')
                                ->colors([
                                    'success' => 'active',
                                    'warning' => 'pending',
                                    'danger' => 'expired',
                                    'secondary' => 'suspended',
                                ])
                                ->icons([
                                    'heroicon-o-check-circle' => 'active',
                                    'heroicon-o-clock' => 'pending',
                                    'heroicon-o-x-circle' => 'expired',
                                    'heroicon-o-pause-circle' => 'suspended',
                                ])
                                ->size('sm'),
                        ])->from('md'),

                        Tables\Columns\TextColumn::make('url')
                            ->label('Website')
                            ->limit(40)
                            ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                return $column->getState();
                            })
                            ->url(fn ($record) => $record->url)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-arrow-top-right-on-square')
                            ->color('info')
                            ->size('sm'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('start_date')
                                ->label('Started')
                                ->date()
                                ->color('success')
                                ->size('xs')
                                ->placeholder('Not set'),

                            Tables\Columns\TextColumn::make('end_date')
                                ->label('Ends')
                                ->date()
                                ->color('warning')
                                ->size('xs')
                                ->placeholder('Ongoing'),
                        ])->from('lg'),
                    ]),
                ])->from('md'),

                // Fallback columns for mobile
                Tables\Columns\TextColumn::make('partner_name')
                    ->weight('bold')
                    ->searchable()
                    ->placeholder('Partner Name')
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'expired',
                        'secondary' => 'suspended',
                    ])
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\SelectFilter::make('cooperation_type')
                    ->label('Cooperation Type')
                    ->options([
                        'academic' => 'Academic Collaboration',
                        'research' => 'Research Partnership',
                        'industry' => 'Industry Partnership',
                        'government' => 'Government Collaboration',
                        'international' => 'International Partnership',
                        'ngo' => 'NGO Partnership',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'expired' => 'Expired',
                        'suspended' => 'Suspended',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('has_logo')
                    ->label('Has Logo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('active_partnerships')
                    ->label('Active Partnerships')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'active')),

                Tables\Filters\Filter::make('expiring_soon')
                    ->label('Expiring Soon (30 days)')
                    ->query(fn (Builder $query): Builder =>
                        $query->where('end_date', '<=', now()->addDays(30))
                              ->where('end_date', '>=', now())
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver()
                        ->modalWidth('md'),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Tables\Actions\Action::make('visit_website')
                        ->label('Visit Website')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->color('info')
                        ->url(fn (Cooperation $record): string => $record->url)
                        ->openUrlInNewTab(),
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
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'active']);
                            }
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('suspend')
                        ->label('Suspend Selected')
                        ->icon('heroicon-o-pause-circle')
                        ->color('warning')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'suspended']);
                            }
                        })
                        ->requiresConfirmation(),
                ])
                ->label('Bulk Actions'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add First Partnership')
                    ->icon('heroicon-o-user-group'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListCooperations::route('/'),
            'create' => Pages\CreateCooperation::route('/create'),
            'edit' => Pages\EditCooperation::route('/{record}/edit'),
        ];
    }
}
