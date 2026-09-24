<?php

namespace App\Filament\Pages;

use App\Models\BlogPost;
use App\Models\Event;
use App\Models\EventGalleryItem;
use App\Models\SiteSetting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class MediaLibrary extends Page
{
    protected static string $view = 'filament.pages.media-library';

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Site management';
    protected static ?string $navigationLabel = 'Media library';
    protected static ?string $title = 'Media library';

    public array $selectedFiles = [];

    public function getFoldersProperty(): array
    {
        return collect($this->getImageFilesProperty())
            ->groupBy('folder')
            ->sortKeys()
            ->map(fn ($files, $folder): array => [
                'name' => $folder,
                'files' => $files->values()->all(),
            ])
            ->values()
            ->all();
    }

    public function getImageFilesProperty(): array
    {
        $disk = Storage::disk('public');
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'svg'];

        return collect($disk->allFiles())
            ->filter(fn (string $path): bool => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $extensions, true))
            ->map(function (string $path) use ($disk): array {
                return [
                    'path' => $path,
                    'name' => basename($path),
                    'folder' => dirname($path) === '.' ? 'Root' : dirname($path),
                    'url' => $disk->url($path),
                    'size' => $disk->size($path),
                ];
            })
            ->sortBy('path')
            ->values()
            ->all();
    }

    public function deleteSelectedFiles(): void
    {
        $selected = collect($this->selectedFiles)
            ->map(fn ($path): ?string => $this->normalizePath($path))
            ->filter()
            ->unique()
            ->values();

        if ($selected->isEmpty()) {
            Notification::make()
                ->title('No images selected')
                ->warning()
                ->send();

            return;
        }

        $disk = Storage::disk('public');
        $existing = collect($this->getImageFilesProperty())->pluck('path');
        $references = $this->referencedPaths();
        $protected = $selected->intersect($references);
        $deletable = $selected->intersect($existing)->diff($protected)->values();

        if ($deletable->isNotEmpty()) {
            $disk->delete($deletable->all());
        }

        $this->selectedFiles = [];

        $notification = Notification::make()
            ->title($deletable->count() . ' image(s) deleted')
            ->success();

        if ($protected->isNotEmpty()) {
            $notification
                ->title($deletable->count() . ' image(s) deleted; ' . $protected->count() . ' protected')
                ->body('Protected images are still referenced by site content.')
                ->warning();
        }

        $notification->send();
    }

    private function referencedPaths(): \Illuminate\Support\Collection
    {
        $paths = collect();
        $settings = SiteSetting::query()->get([
            'logo_path',
            'favicon_path',
            'login_wallpaper',
            'hero_slides',
            'events_logo_path',
            'events_hero_image',
            'growth_logo_path',
            'growth_hero_image',
            'training_logo_path',
            'training_hero_image',
        ]);

        foreach ($settings as $setting) {
            foreach ([
                $setting->logo_path,
                $setting->favicon_path,
                $setting->login_wallpaper,
                $setting->events_logo_path,
                $setting->events_hero_image,
                $setting->growth_logo_path,
                $setting->growth_hero_image,
                $setting->training_logo_path,
                $setting->training_hero_image,
            ] as $path) {
                $paths->push($path);
            }

            $paths = $paths->merge($setting->hero_slides ?: []);
        }

        return $paths
            ->merge(Event::query()->pluck('banner_image'))
            ->merge(EventGalleryItem::query()->pluck('image_path'))
            ->merge(BlogPost::query()->pluck('cover_image'))
            ->map(fn ($path): ?string => $this->normalizePath($path))
            ->filter()
            ->unique()
            ->values();
    }

    private function normalizePath(mixed $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', trim($path)), '/');

        if (str_starts_with($path, '../') || str_contains($path, '/../') || preg_match('/^[A-Za-z]:\//', $path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return null;
        }

        return $path;
    }
}