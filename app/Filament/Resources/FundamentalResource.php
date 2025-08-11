<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FundamentalResource\Pages;
use App\Filament\Resources\FundamentalResource\RelationManagers;
use App\Models\Fundamental;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FundamentalResource extends Resource
{
    protected static ?string $model = Fundamental::class;
    protected static ?string $navigationGroup = 'Institutional & Profile';

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('University Vision & Mission')
                    ->description('Define the fundamental principles and aspirations of the university')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Vision & Mission Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/fundamentals/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'fundamental_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                        Forms\Components\RichEditor::make('vision')
                                            ->label('University Vision')
                                            ->required()
                                            ->placeholder('Enter the university vision statement...')
                                            ->helperText('Describe what the university aspires to become')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'blockquote',
                                                'undo',
                                                'redo',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('mission')
                                            ->label('University Mission')
                                            ->required()
                                            ->placeholder('Enter the university mission statement...')
                                            ->helperText('Describe the university purpose and how it serves students and society')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'blockquote',
                                                'undo',
                                                'redo',
                                            ])
                                            ->columnSpanFull(),
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
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\ImageColumn::make('image')
                            ->height(60)
                            ->width(80)
                            ->defaultImageUrl(asset('images/default-fundamental.png'))
                            ->grow(false),

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('vision')
                                ->label('Vision')
                                ->weight('bold')
                                ->color('primary')
                                ->size('sm')
                                ->html()
                                ->limit(120)
                                ->wrap()
                                ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                    $state = $column->getState();
                                    $cleanText = strip_tags($state);
                                    return strlen($cleanText) > 120 ? $cleanText : null;
                                })
                                ->prefix('VISION: ')
                                ->searchable(),

                            Tables\Columns\TextColumn::make('mission')
                                ->label('Mission')
                                ->color('gray')
                                ->size('sm')
                                ->html()
                                ->limit(150)
                                ->wrap()
                                ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                    $state = $column->getState();
                                    $cleanText = strip_tags($state);
                                    return strlen($cleanText) > 150 ? $cleanText : null;
                                })
                                ->prefix('MISSION: ')
                                ->searchable(),
                        ]),
                    ]),

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
                Tables\Filters\Filter::make('has_image')
                    ->label('Has Image')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('has_vision')
                    ->label('Has Vision')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('vision')),

                Tables\Filters\Filter::make('has_mission')
                    ->label('Has Mission')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('mission')),

                Tables\Filters\Filter::make('complete')
                    ->label('Complete (Vision & Mission)')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereNotNull('vision')
                              ->whereNotNull('mission')
                              ->where('vision', '!=', '')
                              ->where('mission', '!=', '')
                              ->where('vision', '!=', '<p></p>')
                              ->where('mission', '!=', '<p></p>')
                    ),

                Tables\Filters\Filter::make('recent')
                    ->label('Recently Updated (Last 30 days)')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(30))),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver()
                        ->modalWidth('xl'),
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
                    ->label('Create Vision & Mission')
                    ->icon('heroicon-o-light-bulb'),
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
            'index' => Pages\ListFundamentals::route('/'),
            'create' => Pages\CreateFundamental::route('/create'),
            'edit' => Pages\EditFundamental::route('/{record}/edit'),
        ];
    }
}
