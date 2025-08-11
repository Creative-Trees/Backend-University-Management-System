<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoryResource\Pages;
use App\Filament\Resources\HistoryResource\RelationManagers;
use App\Models\History;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;
    protected static ?string $navigationGroup = ' Infrastructure & Support';

    protected static ?string $navigationIcon = 'heroicon-o-clock';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('University History')
                    ->description('Manage university historical information and milestones')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Historical Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/history/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'history_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->moveFiles()
                                    ->previewable(true)
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Historical Content')
                                    ->required()
                                    ->placeholder('Enter university history and milestones...')
                                    ->helperText('Describe the university journey, achievements, and important milestones')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                        'link',
                                        'undo',
                                        'redo',
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
                            ->label('Historical Image')
                            ->circular()
                            ->size(80)
                            ->defaultImageUrl(url('/storage/uploads/placeholders/history.png'))
                            ->extraAttributes(['class' => 'ring-2 ring-primary-500']),
                    ])->space(1),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('content')
                            ->label('Historical Content')
                            ->formatStateUsing(fn (string $state): string => strip_tags($state))
                            ->words(30)
                            ->tooltip(fn (string $state): string => strip_tags($state))
                            ->weight('medium')
                            ->color('gray')
                            ->wrap(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Created')
                                ->dateTime('d M Y, H:i')
                                ->size('sm')
                                ->color('gray'),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Updated')
                                ->dateTime('d M Y, H:i')
                                ->size('sm')
                                ->color('gray')
                                ->since(),
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
                Tables\Filters\Filter::make('has_image')
                    ->label('With Image')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent')
                    ->label('Recent Updates')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('created_today')
                    ->label('Created Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View Details'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Content'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete History'),
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
                    ->label('Add First History Entry')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => Pages\ListHistories::route('/'),
            'create' => Pages\CreateHistory::route('/create'),
            'edit' => Pages\EditHistory::route('/{record}/edit'),
        ];
    }
}
