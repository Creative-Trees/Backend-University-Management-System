<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GreetingResource\Pages;
use App\Filament\Resources\GreetingResource\RelationManagers;
use App\Models\Greeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GreetingResource extends Resource
{
    protected static ?string $model = Greeting::class;
    protected static ?string $navigationGroup = 'Content & Communication';

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Welcome Greeting')
                    ->description('Create and manage welcome messages and greetings for the university')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Greeting Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/greetings/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'greeting_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                    ->label('Greeting Message')
                                    ->required()
                                    ->placeholder('Enter your welcome greeting message...')
                                    ->helperText('Create a warm and welcoming message for visitors')
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
                    Tables\Columns\ImageColumn::make('image')
                        ->height(60)
                        ->width(80)
                        ->defaultImageUrl(asset('images/default-greeting.png'))
                        ->grow(false),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('content')
                            ->label('Greeting Message')
                            ->weight('bold')
                            ->color('primary')
                            ->size('sm')
                            ->html()
                            ->limit(150)
                            ->wrap()
                            ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                                $state = $column->getState();
                                $cleanText = strip_tags($state);
                                return strlen($cleanText) > 150 ? $cleanText : null;
                            })
                            ->searchable(),

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
                    ]),
                ])->from('md'),

                // Fallback columns for mobile
                Tables\Columns\TextColumn::make('content')
                    ->html()
                    ->limit(80)
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

                Tables\Filters\Filter::make('has_content')
                    ->label('Has Content')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereNotNull('content')
                              ->where('content', '!=', '')
                              ->where('content', '!=', '<p></p>')
                    ),

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
                        ->modalWidth('lg'),
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
                    ->label('Create First Greeting')
                    ->icon('heroicon-o-hand-raised'),
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
            'index' => Pages\ListGreetings::route('/'),
            'create' => Pages\CreateGreeting::route('/create'),
            'edit' => Pages\EditGreeting::route('/{record}/edit'),
        ];
    }
}
