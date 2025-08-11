<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationGroup = 'Core System & Management';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Admin Profile Information')
                    ->description('Manage administrator profile and credentials')
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
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->directory('uploads/admin/images')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string =>
                                            'admin_' . now()->format('Y_m_d_His') . '_' . str()->random(8) . '.' . $file->getClientOriginalExtension()
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
                                            ->placeholder('Enter administrator full name')
                                            ->prefixIcon('heroicon-o-user'),

                                        Forms\Components\TextInput::make('nip')
                                            ->label('NIP (Employee ID)')
                                            ->required()
                                            ->maxLength(20)
                                            ->unique(ignoreRecord: true)
                                            ->placeholder('Enter NIP/Employee ID')
                                            ->prefixIcon('heroicon-o-identification')
                                            ->alphaNum(),

                                        Forms\Components\TextInput::make('position')
                                            ->label('Position/Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter job position or title')
                                            ->prefixIcon('heroicon-o-briefcase'),
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
                        ->defaultImageUrl(asset('images/default-avatar.png'))
                        ->grow(false),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight('bold')
                            ->color('primary')
                            ->size('lg')
                            ->searchable()
                            ->sortable(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('nip')
                                ->label('NIP')
                                ->badge()
                                ->color('info')
                                ->prefix('ID: ')
                                ->searchable()
                                ->copyable()
                                ->size('sm'),

                            Tables\Columns\TextColumn::make('position')
                                ->badge()
                                ->color('success')
                                ->searchable()
                                ->size('sm'),
                        ])->from('md'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Joined')
                                ->since()
                                ->color('gray')
                                ->size('sm'),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Last Updated')
                                ->since()
                                ->color('warning')
                                ->size('sm'),
                        ])->from('lg'),
                    ]),
                ])->from('md'),

                // Fallback columns for mobile
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->searchable()
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('position')
                    ->badge()
                    ->color('success')
                    ->visibleFrom('sm')
                    ->hiddenFrom('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->options([
                        'Rektor' => 'Rektor',
                        'Wakil Rektor' => 'Wakil Rektor',
                        'Dekan' => 'Dekan',
                        'Wakil Dekan' => 'Wakil Dekan',
                        'Kepala Program Studi' => 'Kepala Program Studi',
                        'Sekretaris' => 'Sekretaris',
                        'Staff Administrasi' => 'Staff Administrasi',
                        'Kepala Bagian' => 'Kepala Bagian',
                    ])
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('has_image')
                    ->label('Has Profile Photo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('recent')
                    ->label('Recently Added (Last 30 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30))),

                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status')
                    ->placeholder('All admins')
                    ->trueLabel('Active admins')
                    ->falseLabel('Inactive admins'),
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
                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function ($records) {
                            // Export functionality can be implemented here
                        }),
                ])
                ->label('Bulk Actions'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create First Admin')
                    ->icon('heroicon-o-plus-circle'),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
