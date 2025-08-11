<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Core System & Management';
    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Account Information')
                    ->description('Manage user account credentials and authentication settings')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter complete user name')
                                    ->helperText('Full name as it will appear throughout the system')
                                    ->autocomplete('name')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('user@university.edu')
                                    ->helperText('Primary email for login and system notifications')
                                    ->unique(ignoreRecord: true)
                                    ->autocomplete('email')
                                    ->suffixIcon('heroicon-m-envelope')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->maxLength(255)
                                    ->placeholder('Enter a secure password')
                                    ->helperText('Minimum 8 characters. Leave blank when editing to keep current password.')
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->autocomplete('new-password')
                                    ->suffixIcon('heroicon-m-lock-closed')
                                    ->columnSpan([
                                        'sm' => 2,
                                        'md' => 1,
                                    ]),

                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->label('Email Verification Status')
                                    ->placeholder('Set verification timestamp')
                                    ->helperText('Mark when the email address was verified (leave empty for unverified)')
                                    ->displayFormat('d/m/Y H:i')
                                    ->suffixIcon('heroicon-m-check-badge')
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
                        Tables\Columns\TextColumn::make('name')
                            ->label('User Name')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->icon('heroicon-m-user-circle')
                            ->wrap(),

                        Tables\Columns\TextColumn::make('email')
                            ->label('Email Address')
                            ->searchable()
                            ->icon('heroicon-m-envelope')
                            ->color('blue')
                            ->size('sm')
                            ->copyable()
                            ->copyMessage('Email address copied to clipboard!')
                            ->copyMessageDuration(2000)
                            ->wrap(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\IconColumn::make('email_verified_at')
                                ->label('Verification Status')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-badge')
                                ->falseIcon('heroicon-o-x-circle')
                                ->trueColor('success')
                                ->falseColor('danger')
                                ->tooltip(fn ($record): string =>
                                    $record->email_verified_at
                                        ? 'Verified on ' . $record->email_verified_at->format('d M Y, H:i')
                                        : 'Email not verified'
                                ),

                            Tables\Columns\TextColumn::make('email_verified_at')
                                ->label('Verified Date')
                                ->dateTime('d M Y')
                                ->size('xs')
                                ->color('gray')
                                ->placeholder('Unverified')
                                ->icon('heroicon-m-calendar-days'),
                        ]),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('created_at')
                                ->label('Account Created')
                                ->dateTime('d M Y')
                                ->size('xs')
                                ->color('gray')
                                ->icon('heroicon-m-user-plus')
                                ->tooltip(fn ($record): string => 'Joined on ' . $record->created_at->format('F d, Y \a\t H:i')),

                            Tables\Columns\TextColumn::make('updated_at')
                                ->label('Last Activity')
                                ->since()
                                ->size('xs')
                                ->color('gray')
                                ->icon('heroicon-m-clock')
                                ->tooltip(fn ($record): string => 'Last updated: ' . $record->updated_at->format('d M Y, H:i')),
                        ]),
                    ])->space(2),
                ])->from('md'),
            ])
            ->contentGrid([
                'md' => 1,
                'lg' => 1,
            ])
            ->paginated([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('verification_status')
                    ->label('Email Verification')
                    ->options([
                        'verified' => 'Email Verified',
                        'unverified' => 'Email Unverified',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'verified' => $query->whereNotNull('email_verified_at'),
                            'unverified' => $query->whereNull('email_verified_at'),
                            default => $query,
                        };
                    }),

                Tables\Filters\Filter::make('recent_users')
                    ->label('New Users (30 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30)))
                    ->indicator('New Users'),

                Tables\Filters\Filter::make('joined_today')
                    ->label('Joined Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today()))
                    ->indicator('Today'),

                Tables\Filters\Filter::make('active_users')
                    ->label('Recently Active (7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '>=', now()->subDays(7)))
                    ->indicator('Active'),

                Tables\Filters\Filter::make('inactive_users')
                    ->label('Inactive (30+ days)')
                    ->query(fn (Builder $query): Builder => $query->where('updated_at', '<=', now()->subDays(30)))
                    ->indicator('Inactive'),
            ])
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View Details'),

                    Tables\Actions\EditAction::make()
                        ->label('Edit Account'),

                    Tables\Actions\Action::make('toggle_verification')
                        ->label(fn ($record): string => $record->email_verified_at ? 'Unverify Email' : 'Verify Email')
                        ->icon(fn ($record): string => $record->email_verified_at ? 'heroicon-o-x-circle' : 'heroicon-o-check-badge')
                        ->color(fn ($record): string => $record->email_verified_at ? 'danger' : 'success')
                        ->action(function ($record) {
                            $record->update([
                                'email_verified_at' => $record->email_verified_at ? null : now()
                            ]);
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\Action::make('reset_password')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->placeholder('Enter new password'),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'password' => Hash::make($data['new_password'])
                            ]);
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteAction::make()
                        ->label('Delete User'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('gray')
                ->button()
                ->outlined(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify_emails')
                        ->label('Verify Selected Emails')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(fn ($record) => $record->update(['email_verified_at' => now()]));
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('unverify_emails')
                        ->label('Unverify Selected Emails')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(fn ($record) => $record->update(['email_verified_at' => null]));
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create First User Account')
                    ->icon('heroicon-o-plus-circle'),
            ])
            ->emptyStateHeading('No Users Found')
            ->emptyStateDescription('Get started by creating your first user account.')
            ->defaultSort('name', 'asc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->extremePaginationLinks();
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
