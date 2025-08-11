<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationGroup = 'Content & Communication';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('News Article')
                    ->description('Create and manage university news articles and announcements')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Article Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter news article title')
                                    ->helperText('Use clear, descriptive titles for better SEO')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('auto-generated-from-title')
                                    ->helperText('URL-friendly version of the title (auto-generated)')
                                    ->unique(ignoreRecord: true)
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Featured Image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/news/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'news_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->moveFiles()
                                    ->previewable(true)
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\Select::make('users_id')
                                    ->label('Author')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Select article author')
                                    ->helperText('Choose the author of this news article')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\RichEditor::make('content')
                            ->label('Article Content')
                            ->required()
                            ->placeholder('Write your news article content here...')
                            ->helperText('Use the rich text editor to format your article with headings, lists, and links')
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
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\ImageColumn::make('image')
                            ->label('Featured Image')
                            ->size(80)
                            ->defaultImageUrl(url('/storage/uploads/placeholders/news.png'))
                            ->extraAttributes(['class' => 'rounded-lg ring-2 ring-primary-500']),
                    ])->space(1),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('title')
                            ->label('Article Title')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->wrap(),

                        Tables\Columns\TextColumn::make('content')
                            ->label('Content Preview')
                            ->formatStateUsing(fn (string $state): string => strip_tags($state))
                            ->words(20)
                            ->tooltip(fn (string $state): string => strip_tags($state))
                            ->color('gray')
                            ->size('sm')
                            ->wrap(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('user.name')
                                ->label('Author')
                                ->searchable()
                                ->badge()
                                ->color('success')
                                ->icon('heroicon-m-user')
                                ->size('sm'),

                            Tables\Columns\TextColumn::make('slug')
                                ->label('URL Slug')
                                ->searchable()
                                ->color('gray')
                                ->size('xs')
                                ->prefix('/')
                                ->copyable()
                                ->copyMessage('Slug copied!')
                                ->copyMessageDuration(1500),
                        ]),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Published')
                                ->dateTime('d M Y, H:i')
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
                Tables\Filters\SelectFilter::make('user')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\Filter::make('has_image')
                    ->label('With Featured Image')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent_articles')
                    ->label('Recent Articles')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),

                Tables\Filters\Filter::make('published_today')
                    ->label('Published Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),

                Tables\Filters\Filter::make('long_articles')
                    ->label('Long Articles')
                    ->query(fn (Builder $query): Builder => $query->whereRaw('LENGTH(content) > 1000')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Read Article'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Article'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete Article'),
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
                    ->label('Create First News Article')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
