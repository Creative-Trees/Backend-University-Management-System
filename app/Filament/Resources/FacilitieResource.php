<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilitieResource\Pages;
use App\Filament\Resources\FacilitieResource\RelationManagers;
use App\Models\Facilitie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FacilitieResource extends Resource
{
    protected static ?string $model = Facilitie::class;
    protected static ?string $navigationGroup = ' Infrastructure & Support';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Facility Information')
                    ->description('Manage university facilities and infrastructure details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Facility Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/facilities/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'facility_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                        Forms\Components\TextInput::make('name')
                                            ->label('Facility Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter facility name')
                                            ->prefixIcon('heroicon-o-building-library'),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Facility Description')
                                            ->required()
                                            ->maxLength(500)
                                            ->placeholder('Describe the facility and its features...')
                                            ->rows(4),
                                    ])
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
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
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height(60)
                        ->width(60)
                        ->circular()
                        ->defaultImageUrl(asset('images/default-facility.png'))
                        ->grow(false),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight('bold')
                            ->color('primary')
                            ->size('lg')
                            ->searchable()
                            ->sortable()
                            ->limit(50)
                            ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                $state = $column->getState();
                                return strlen($state) > 50 ? $state : null;
                            }),

                        Tables\Columns\TextColumn::make('description')
                            ->color('gray')
                            ->size('sm')
                            ->limit(100)
                            ->wrap()
                            ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                $state = $column->getState();
                                return strlen($state) > 100 ? $state : null;
                            })
                            ->searchable(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Added')
                                ->since()
                                ->color('success')
                                ->size('xs'),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Updated')
                                ->since()
                                ->color('warning')
                                ->size('xs'),
                        ])->from('lg'),
                    ]),
                ])->from('md'),

                // Fallback columns for mobile
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->searchable()
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable()
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\Filter::make('has_image')
                    ->label('Has Image')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent')
                    ->label('Recently Added (Last 30 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('updated_recently')
                    ->label('Recently Updated (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(7))),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver()
                        ->modalWidth('md'),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
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
                    ->label('Add First Facility')
                    ->icon('heroicon-o-building-library'),
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacilitie::route('/create'),
            'edit' => Pages\EditFacilitie::route('/{record}/edit'),
        ];
    }
}
