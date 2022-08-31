
# Add preload and prefetch links based your Mix manifest

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mkinyua53/laravel-mix-preload.svg?style=flat-square)](https://packagist.org/packages/mkinyua53/laravel-mix-preload)
![Build Status](https://github.com/mkinyua53/laravel-mix-preload/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/mkinyua53/laravel-mix-preload.svg?style=flat-square)](https://packagist.org/packages/mkinyua53/laravel-mix-preload)

```blade
<head>
    <title>Preloading things</title>

    @preload
</head>
```

This package exposes a `@preload` Blade directive that renders preload and prefetch links based on the contents in `mix-manifest.json`. Declaring what should be preloaded or prefetched is simple, just make sure `preload` or `prefetch` is part of the chunk name.

If this is your mix manifest:

```json
{
    "/js/app.js": "/js/app.js",
    "/css/app.css": "/css/app.css",
    "/css/prefetch-otherpagecss.css": "/css/prefetch-otherpagecss.css",
    "/js/preload-biglibrary.js": "/js/preload-biglibrary.js",
    "/js/vendors~preload-biglibrary.js": "/js/vendors~preload-biglibrary.js"
}
```

The following links will be rendered:

```html
<link rel="prefetch" href="/css/prefetch-otherpagecss.css" as="style">
<link rel="preload" href="/js/preload-biglibrary.js" as="script">
<link rel="preload" href="/js/vendors~preload-biglibrary.js" as="script">
```

Not sure what this is about? Read Addy Osmani's article [Preload, Prefetch And Priorities in Chrome](https://medium.com/reloading/preload-prefetch-and-priorities-in-chrome-776165961bbf).

In addition to the above, you should set your config values appropriately to add or remove more assets from preload/prefetch

## Support

## Installation

You can install the package via composer:

```bash
composer require mkinyua53/laravel-mix-preload
```

Publish the config

```bash
php artisan vendor:publish --tag=preloader-config
```

## Usage

Add a `@preload` directive to your applications layout file(s).

```blade
<!doctype html>
<html>
    <head>
        ...
        @preload
    </head>
    <body>
        ...
    </body>
</html>
```

You can determine which scripts need to be preloaded or prefetched by making sure `preload` or `prefetch` is part of their file names. You can set the file name by creating a new entry in Mix, or by using dynamic imports.

### Adding a second entry

By default, Laravel sets up Mix with a single `app.js` entry. If you have another script outside of `app.js` that you want to have preloaded, make sure `preload` is part of the entry name.

```js
mix
    .js('resources/js/app.js', 'public/js');
    .js('resources/js/preload-maps.js', 'public/js');
```

If you want to prefetch the script instead, make sure `prefetch` is part of the entry name.

```js
mix
    .js('resources/js/app.js', 'public/js');
    .js('resources/js/prefetch-maps.js', 'public/js');
```

### Using dynamic imports with custom chunk names

If you want to preload a chunk of your application scripts, make sure `preload` is part of the chunk name. You can use Webpack's magic `webpackChunkName` comment to set the module's chunk name.

```js
import('./maps' /* webpackChunkName: "preload-maps" */).then(maps => {
    maps.init();
});
```

The same applies to prefetching.

```js
import('./maps' /* webpackChunkName: "prefetch-maps" */).then(maps => {
    maps.init();
});
```

### Testing

``` bash
composer test
```


## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
