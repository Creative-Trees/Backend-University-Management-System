<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;
    protected static ?string $navigationGroup = 'Content & Communication';

    protected static ?string $navigationIcon = 'heroicon-o-bell';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Announcement Content')
                    ->description('Create and manage university announcements')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Announcement Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter announcement title')
                                    ->prefixIcon('heroicon-o-megaphone')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                        if (! $get('slug') && $state) {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->columnSpan([
                                        'sm' => 3,
                                        'md' => 2,
                                    ]),

                                Forms\Components\Select::make('users_id')
                                    ->label('Author')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Select author')
                                    ->prefixIcon('heroicon-o-user')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columnSpan([
                                        'sm' => 3,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\RichEditor::make('content')
                            ->label('Announcement Content')
                            ->required()
                            ->placeholder('Write your announcement content here...')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('announcement-url-slug')
                                    ->prefixIcon('heroicon-o-link')
                                    ->helperText('Auto-generated from title, but can be customized')
                                    ->rules(['alpha_dash'])
                                    ->columnSpan(1),

                                Forms\Components\Select::make('status')
                                    ->label('Publication Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'scheduled' => 'Scheduled',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->prefixIcon('heroicon-o-eye')
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publication Date')
                                    ->placeholder('Select publication date')
                                    ->prefixIcon('heroicon-o-calendar')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('priority')
                                    ->label('Priority Level')
                                    ->options([
                                        'low' => 'Low',
                                        'normal' => 'Normal',
                                        'high' => 'High',
                                        'urgent' => 'Urgent',
                                    ])
                                    ->default('normal')
                                    ->prefixIcon('heroicon-o-flag')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('category')
                                    ->label('Category')
                                    ->options([
                                        'academic' => 'Academic',
                                        'administrative' => 'Administrative',
                                        'events' => 'Events',
                                        'general' => 'General',
                                        'urgent' => 'Urgent Notice',
                                    ])
                                    ->prefixIcon('heroicon-o-tag')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Additional Settings')
                    ->description('Optional settings for advanced announcement features')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Announcement')
                                    ->helperText('Display prominently on homepage')
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('send_notification')
                                    ->label('Send Push Notification')
                                    ->helperText('Notify users via push notification')
                                    ->default(true)
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Add tags for better organization')
                            ->separator(',')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('title')
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

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\BadgeColumn::make('status')
                                ->colors([
                                    'danger' => 'draft',
                                    'success' => 'published',
                                    'warning' => 'scheduled',
                                    'secondary' => 'archived',
                                ])
                                ->icons([
                                    'heroicon-o-pencil' => 'draft',
                                    'heroicon-o-eye' => 'published',
                                    'heroicon-o-clock' => 'scheduled',
                                    'heroicon-o-archive-box' => 'archived',
                                ]),

                            Tables\Columns\BadgeColumn::make('priority')
                                ->colors([
                                    'secondary' => 'low',
                                    'primary' => 'normal',
                                    'warning' => 'high',
                                    'danger' => 'urgent',
                                ])
                                ->size('sm'),
                        ])->alignment('end'),
                    ]),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('user.name')
                            ->label('Author')
                            ->icon('heroicon-o-user')
                            ->color('gray')
                            ->size('sm'),

                        Tables\Columns\TextColumn::make('category')
                            ->badge()
                            ->color('info')
                            ->size('sm'),
                    ])->from('md'),

                    Tables\Columns\TextColumn::make('content')
                        ->html()
                        ->limit(120)
                        ->color('gray')
                        ->size('sm')
                        ->wrap(),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('published_at')
                            ->label('Published')
                            ->since()
                            ->color('success')
                            ->size('xs')
                            ->placeholder('Not published'),

                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\IconColumn::make('is_featured')
                                ->boolean()
                                ->trueIcon('heroicon-o-star')
                                ->falseIcon('')
                                ->trueColor('warning')
                                ->tooltip('Featured'),

                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Created')
                                ->since()
                                ->color('gray')
                                ->size('xs'),
                        ])->alignment('end'),
                    ])->from('lg'),
                ])->space(2),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                        'archived' => 'Archived',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'academic' => 'Academic',
                        'administrative' => 'Administrative',
                        'events' => 'Events',
                        'general' => 'General',
                        'urgent' => 'Urgent Notice',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All announcements')
                    ->trueLabel('Featured only')
                    ->falseLabel('Non-featured only'),

                Tables\Filters\Filter::make('published')
                    ->label('Published')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('published_at')),

                Tables\Filters\Filter::make('recent')
                    ->label('Recent (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver()
                        ->modalWidth('xl'),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Tables\Actions\Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->url(fn (Announcement $record): string => route('announcements.show', $record->slug))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('duplicate')
                        ->label('Duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('gray')
                        ->action(function (Announcement $record) {
                            $record->replicate()->save();
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
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'published',
                                    'published_at' => now(),
                                ]);
                            }
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('archive')
                        ->label('Archive Selected')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'archived']);
                            }
                        })
                        ->requiresConfirmation(),
                ])
                ->label('Bulk Actions'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create First Announcement')
                    ->icon('heroicon-o-megaphone'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->poll('30s')
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
