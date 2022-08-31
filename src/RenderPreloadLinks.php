<?php

namespace Mkinyua53\MixPreload;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class RenderPreloadLinks
{
    /** @var array */
    protected $manifest;

    public static function create(string $manifestPath = null): RenderPreloadLinks
    {
        if (! $manifestPath) {
            $manifestPath = public_path('mix-manifest.json');
        }

        $manifest = json_decode(
            file_get_contents($manifestPath),
            true
        );

        return new self($manifest);
    }

    public function __construct(array $manifest)
    {
        $this->manifest = $manifest;
    }

    public function __invoke(): HtmlString
    {
        $using = config('preloader.using', 'path');

        return $this->getManifestEntries()
            ->mapSpread(function (string $path, string $name) use ($using) {
                $rel = $this->getRelAttribute($name);

                if (! $rel) {
                    return null;
                }

                $as = $this->getAsAttribute($path);

                if (! $as) {
                    return null;
                }
                $uri = $using == 'name' ? $name : $path;

                return "<link rel=\"{$rel}\" href=\"{$uri}\" as=\"{$as}\">";
            })
            ->filter()
            ->pipe(function (Collection $links) {
                return new HtmlString($links->implode("\n"));
            });
    }

    protected function getManifestEntries(): Collection
    {
        return collect($this->manifest)
            ->map(function (string $path, string $name) {
                return [$path, $name];
            })
            ->values();
    }

    protected function getRelAttribute(string $name): ?string
    {
        if (Str::contains($name, 'preload')) {
            return 'preload';
        }

        if (Str::contains($name, 'prefetch')) {
            return 'prefetch';
        }

        $morePreload = config('preloader.preload.include');
        $excludePreload = config('preloader.preload.exclude');

        if (Str::contains($name, $morePreload) && !Str::contains($name, $excludePreload)) {
            return 'preload';
        }

        $morePrefetch = config('preloader.prefetch.include');
        $excludePrefetch = config('preloader.prefetch.exclude');

        if (Str::contains($name, $morePrefetch) && !Str::contains($name, $excludePrefetch)) {
            return 'prefetch';
        }

        return null;
    }

    protected function getAsAttribute(string $path): ?string
    {
        if (Str::contains($path, '.js')) {
            return 'script';
        }

        if (Str::contains($path, '.css')) {
            return 'style';
        }

        if (Str::contains($path, ['.woff', '.woff2', '.ttf', '.eot', '.svg', '.ttc'])) {
            return 'font';
        }

        return null;
    }
}
