<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LectureResource\Pages;
use App\Filament\Resources\LectureResource\RelationManagers;
use App\Models\Lecture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class LectureResource extends Resource
{
    protected static ?string $model = Lecture::class;
    protected static ?string $navigationGroup = 'Content & Communication';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lecturer Information')
                    ->description('Manage lecturer profile, credentials and academic information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Profile Photo')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '16:9',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/lecturers/photos')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'lecturer_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                            ->placeholder('Enter lecturer full name')
                                            ->helperText('Complete name as it appears on official documents'),

                                        Forms\Components\TextInput::make('nidn')
                                            ->label('NIDN (Lecturer ID Number)')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter NIDN number')
                                            ->helperText('National Lecturer Identification Number')
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('lecturer@university.ac.id')
                                            ->helperText('Official university email address')
                                            ->unique(ignoreRecord: true),
                                    ])
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('education')
                                    ->label('Educational Background')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., S3 Computer Science - MIT')
                                    ->helperText('Highest degree and institution'),

                                Forms\Components\TextInput::make('position')
                                    ->label('Academic Position')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Professor, Associate Professor')
                                    ->helperText('Current academic rank or position'),

                                Forms\Components\TextInput::make('topic')
                                    ->label('Research Topic/Specialization')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Machine Learning, Software Engineering')
                                    ->helperText('Main area of expertise or research focus')
                                    ->columnSpan(2),
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
                            ->label('Photo')
                            ->circular()
                            ->size(80)
                            ->defaultImageUrl(url('/storage/uploads/placeholders/lecturer.png'))
                            ->extraAttributes(['class' => 'ring-2 ring-primary-500']),
                    ])->space(1),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->label('Name')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('nidn')
                                ->label('NIDN')
                                ->searchable()
                                ->badge()
                                ->color('gray')
                                ->size('sm'),

                            Tables\Columns\TextColumn::make('position')
                                ->label('Position')
                                ->searchable()
                                ->badge()
                                ->color('success')
                                ->size('sm'),
                        ]),

                        Tables\Columns\TextColumn::make('education')
                            ->label('Education')
                            ->searchable()
                            ->color('gray')
                            ->size('sm')
                            ->icon('heroicon-m-academic-cap')
                            ->wrap(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('email')
                                ->label('Email')
                                ->searchable()
                                ->icon('heroicon-m-envelope')
                                ->color('blue')
                                ->size('sm')
                                ->copyable()
                                ->copyMessage('Email copied!')
                                ->copyMessageDuration(1500),

                            Tables\Columns\TextColumn::make('topic')
                                ->label('Specialization')
                                ->searchable()
                                ->badge()
                                ->color('warning')
                                ->size('sm'),
                        ]),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Joined')
                                ->dateTime('d M Y')
                                ->size('xs')
                                ->color('gray'),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Updated')
                                ->since()
                                ->size('xs')
                                ->color('gray'),
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
                    ->label('Academic Position')
                    ->options([
                        'Professor' => 'Professor',
                        'Associate Professor' => 'Associate Professor',
                        'Assistant Professor' => 'Assistant Professor',
                        'Lecturer' => 'Lecturer',
                        'Senior Lecturer' => 'Senior Lecturer',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('has_image')
                    ->label('With Photo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent_updates')
                    ->label('Recent Updates')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('created_today')
                    ->label('Added Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View Profile'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Details'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Remove Lecturer'),
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
                    ->label('Add First Lecturer')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('name', 'asc')
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
            'index' => Pages\ListLectures::route('/'),
            'create' => Pages\CreateLecture::route('/create'),
            'edit' => Pages\EditLecture::route('/{record}/edit'),
        ];
    }
}
