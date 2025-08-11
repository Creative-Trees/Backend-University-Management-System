<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationGroup = 'Core System & Management';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
                    ->description('Manage student personal data and academic preferences')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Student Photo')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '3:4',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/students/photos')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'student_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                        Forms\Components\TextInput::make('full_name')
                                            ->label('Full Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter student full name')
                                            ->helperText('Complete name as it appears on official documents'),

                                        Forms\Components\TextInput::make('nickname')
                                            ->label('Nickname / Preferred Name')
                                            ->maxLength(255)
                                            ->placeholder('Enter preferred name or nickname')
                                            ->helperText('How the student prefers to be called (optional)'),

                                        Forms\Components\TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('student@example.com')
                                            ->helperText('Valid email address for communication')
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\TextInput::make('phone_number')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->required()
                                            ->maxLength(15)
                                            ->placeholder('+62 812 3456 7890')
                                            ->helperText('Valid phone number with country code'),
                                    ])
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('admission_path')
                                    ->label('Admission Path')
                                    ->required()
                                    ->options([
                                        'SNBP' => 'SNBP (Seleksi Nasional Berdasarkan Prestasi)',
                                        'SNBT' => 'SNBT (Seleksi Nasional Berdasarkan Tes)',
                                        'Mandiri' => 'Jalur Mandiri',
                                        'Kerjasama' => 'Jalur Kerjasama',
                                        'Transfer' => 'Transfer',
                                        'International' => 'International Program',
                                    ])
                                    ->searchable()
                                    ->placeholder('Select admission path')
                                    ->helperText('How the student was admitted to the university'),

                                Forms\Components\TextInput::make('major_first_choice')
                                    ->label('First Choice Major')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Computer Science, Business Administration')
                                    ->helperText('Primary major preference'),

                                Forms\Components\TextInput::make('major_second_choice')
                                    ->label('Second Choice Major')
                                    ->maxLength(255)
                                    ->placeholder('e.g., Information Systems, Management')
                                    ->helperText('Alternative major preference (optional)')
                                    ->columnSpan(1),
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
                            ->defaultImageUrl(url('/storage/uploads/placeholders/student.png'))
                            ->extraAttributes(['class' => 'ring-2 ring-primary-500']),
                    ])->space(1),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('full_name')
                            ->label('Full Name')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->wrap(),

                        Tables\Columns\TextColumn::make('nickname')
                            ->label('Nickname')
                            ->searchable()
                            ->badge()
                            ->color('gray')
                            ->size('sm')
                            ->placeholder('No nickname'),

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

                            Tables\Columns\TextColumn::make('phone_number')
                                ->label('Phone')
                                ->searchable()
                                ->icon('heroicon-m-phone')
                                ->color('green')
                                ->size('sm')
                                ->copyable()
                                ->copyMessage('Phone copied!')
                                ->copyMessageDuration(1500),
                        ]),

                        Tables\Columns\TextColumn::make('admission_path')
                            ->label('Admission Path')
                            ->searchable()
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'SNBP' => 'success',
                                'SNBT' => 'info',
                                'Mandiri' => 'warning',
                                'Kerjasama' => 'danger',
                                'Transfer' => 'gray',
                                'International' => 'purple',
                                default => 'gray',
                            })
                            ->size('sm'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('major_first_choice')
                                ->label('1st Choice')
                                ->searchable()
                                ->badge()
                                ->color('primary')
                                ->size('xs'),

                            Tables\Columns\TextColumn::make('major_second_choice')
                                ->label('2nd Choice')
                                ->searchable()
                                ->badge()
                                ->color('secondary')
                                ->size('xs')
                                ->placeholder('No 2nd choice'),
                        ]),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Registered')
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
                Tables\Filters\SelectFilter::make('admission_path')
                    ->label('Admission Path')
                    ->options([
                        'SNBP' => 'SNBP',
                        'SNBT' => 'SNBT',
                        'Mandiri' => 'Mandiri',
                        'Kerjasama' => 'Kerjasama',
                        'Transfer' => 'Transfer',
                        'International' => 'International',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('major_first_choice')
                    ->label('First Choice Major')
                    ->searchable()
                    ->multiple(),

                Tables\Filters\Filter::make('has_photo')
                    ->label('With Photo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('has_nickname')
                    ->label('With Nickname')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('nickname')),

                Tables\Filters\Filter::make('has_second_choice')
                    ->label('With 2nd Choice')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('major_second_choice')),

                Tables\Filters\Filter::make('recent_registrations')
                    ->label('Recent Registrations')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('registered_today')
                    ->label('Registered Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View Profile'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Details'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Remove Student'),
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
                    ->label('Add First Student')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('full_name', 'asc')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
