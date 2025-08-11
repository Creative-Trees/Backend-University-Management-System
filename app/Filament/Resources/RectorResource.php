<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RectorResource\Pages;
use App\Filament\Resources\RectorResource\RelationManagers;
use App\Models\Rector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RectorResource extends Resource
{
    protected static ?string $model = Rector::class;
    protected static ?string $navigationGroup = 'Institutional & Profile';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rector Profile')
                    ->description('Manage rector information and official profile')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Official Portrait')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '3:4',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/rectors/portraits')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'rector_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                            ->label('Full Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter rector full name')
                                            ->helperText('Complete name with title and degrees'),

                                        Forms\Components\TextInput::make('position')
                                            ->label('Official Position')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., Rector, Vice Rector I, Vice Rector II')
                                            ->helperText('Current position in university leadership'),
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
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\ImageColumn::make('image')
                            ->label('Portrait')
                            ->circular()
                            ->size(80)
                            ->defaultImageUrl(url('/storage/uploads/placeholders/rector.png'))
                            ->extraAttributes(['class' => 'ring-2 ring-primary-500']),
                    ])->space(1),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->label('Name')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->wrap(),

                        Tables\Columns\TextColumn::make('position')
                            ->label('Position')
                            ->searchable()
                            ->badge()
                            ->color(fn (string $state): string => match (true) {
                                str_contains(strtolower($state), 'rector') && !str_contains(strtolower($state), 'vice') => 'danger',
                                str_contains(strtolower($state), 'vice rector') => 'warning',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match (true) {
                                str_contains(strtolower($state), 'rector') && !str_contains(strtolower($state), 'vice') => 'heroicon-m-star',
                                str_contains(strtolower($state), 'vice rector') => 'heroicon-m-shield-check',
                                default => 'heroicon-m-user',
                            })
                            ->size('sm'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Appointed')
                                ->dateTime('d M Y')
                                ->size('xs')
                                ->color('gray')
                                ->icon('heroicon-m-calendar'),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Updated')
                                ->since()
                                ->size('xs')
                                ->color('gray')
                                ->icon('heroicon-m-clock'),
                        ]),
                    ])->space(2),
                ])->from('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->label('Position')
                    ->options([
                        'Rector' => 'Rector',
                        'Vice Rector I' => 'Vice Rector I',
                        'Vice Rector II' => 'Vice Rector II',
                        'Vice Rector III' => 'Vice Rector III',
                        'Vice Rector IV' => 'Vice Rector IV',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('has_portrait')
                    ->label('With Portrait')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent_updates')
                    ->label('Recent Updates')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('appointed_today')
                    ->label('Appointed Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View Profile'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Details'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Remove Rector'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('gray')
                ->button()
                ->outlined(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Rector Profile')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('position', 'asc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
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
            'index' => Pages\ListRectors::route('/'),
            'create' => Pages\CreateRector::route('/create'),
            'edit' => Pages\EditRector::route('/{record}/edit'),
        ];
    }
}
