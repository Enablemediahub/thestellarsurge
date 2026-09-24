<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Site management';
    protected static ?string $navigationLabel = 'Brand & site settings';
    protected static ?string $modelLabel = 'Brand & site settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Brand identity')
                    ->description('Control the logo, favicon, and browser-facing site name.')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Main logo')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('login_wallpaper')
                            ->label('Admin login wallpaper')
                            ->image()
                            ->disk('public')
                            ->directory('branding/admin')
                            ->visibility('public')
                            ->helperText('This image appears behind the admin login with a plum overlay and low opacity.'),
                    ])->columns(3),

                Forms\Components\Section::make('Hero experience')
                    ->description('Upload the rotating images used behind the homepage hero.')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_slides')
                            ->label('Hero images')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->disk('public')
                            ->directory('branding/hero')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Portal identity')
                    ->description('Set the logo, hero image, and color for Curated Events, Event Planning & Coordination, and Trainings & Masterclasses.')
                    ->schema([
                        Forms\Components\FileUpload::make('events_logo_path')
                            ->label('Curated Events logo')
                            ->image()
                            ->deletable()
                            ->helperText('Shown on the Curated Events portal card and hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('events_hero_image')
                            ->label('Curated Events hero image')
                            ->image()
                            ->deletable()
                            ->helperText('Shown behind the Curated Events portal hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals/heroes')
                            ->visibility('public'),
                        Forms\Components\ColorPicker::make('events_color')
                            ->label('Curated Events color')
                            ->required(),
                        Forms\Components\FileUpload::make('growth_logo_path')
                            ->label('Event Planning & Coordination logo')
                            ->image()
                            ->deletable()
                            ->helperText('Shown on the Event Planning & Coordination portal card and hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('growth_hero_image')
                            ->label('Event Planning & Coordination hero image')
                            ->image()
                            ->deletable()
                            ->helperText('Shown behind the Event Planning & Coordination portal hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals/heroes')
                            ->visibility('public'),
                        Forms\Components\ColorPicker::make('growth_color')
                            ->label('Event Planning & Coordination color')
                            ->required(),
                        Forms\Components\FileUpload::make('training_logo_path')
                            ->label('Trainings & Masterclasses logo')
                            ->image()
                            ->deletable()
                            ->helperText('Shown on the Trainings & Masterclasses portal card and hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('training_hero_image')
                            ->label('Trainings & Masterclasses hero image')
                            ->image()
                            ->deletable()
                            ->helperText('Shown behind the Trainings & Masterclasses portal hero. Remove the current preview to upload a replacement.')
                            ->disk('public')
                            ->directory('branding/portals/heroes')
                            ->visibility('public'),
                        Forms\Components\ColorPicker::make('training_color')
                            ->label('Trainings & Masterclasses color')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Theme colors')
                    ->schema([
                        Forms\Components\ColorPicker::make('plum_color')->label('Plum'),
                        Forms\Components\ColorPicker::make('gold_color')->label('Gold'),
                        Forms\Components\ColorPicker::make('ivory_color')->label('Ivory'),
                    ])->columns(3),

                Forms\Components\Section::make('Contact and social media')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->email(),
                        Forms\Components\TextInput::make('whatsapp_number'),
                        Forms\Components\Repeater::make('social_links')
                            ->schema([
                                Forms\Components\Select::make('platform')
                                    ->options([
                                        'instagram' => 'Instagram',
                                        'facebook' => 'Facebook',
                                        'linkedin' => 'LinkedIn',
                                        'youtube' => 'YouTube',
                                        'tiktok' => 'TikTok',
                                        'x' => 'X',
                                        'whatsapp' => 'WhatsApp',
                                    ])
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('url')->url()->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('footer_credit')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('ticket_scanner_enabled')
                            ->label('Enable ticket scanner portal')
                            ->helperText('Allows ushers to open the phone camera scanner at /events/tickets/.')
                            ->default(true),
                        Forms\Components\TextInput::make('ticket_scanner_url')
                            ->label('Ticket scanner portal URL')
                            ->formatStateUsing(fn (): string => request()->getHost() === 'thestellarsurge.com'
                                ? 'https://events.thestellarsurge.com/tickets/'
                                : route('events.ticket.scanner.local'))
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Select this URL and copy it into WhatsApp or send it directly to the ushers.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')->searchable(),
                Tables\Columns\TextColumn::make('contact_email'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
