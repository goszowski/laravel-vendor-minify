[![Latest Stable Version](https://poser.pugx.org/goszowski/laravel-vendor-minify/v/stable)](https://packagist.org/packages/goszowski/laravel-vendor-minify) [![Total Downloads](https://poser.pugx.org/goszowski/laravel-vendor-minify/downloads)](https://packagist.org/packages/goszowski/laravel-vendor-minify) [![License](https://poser.pugx.org/goszowski/laravel-vendor-minify/license)](https://packagist.org/packages/goszowski/laravel-vendor-minify)
## Laravel Vendor Cleanup and Minify Commands

### 1) Remove tests, documentation, .gitignore files from the vendor dir. 2) Minify all php files in the vendor dir

Require this package:

    composer require goszowski/laravel-vendor-minify

You can now remove all the docs/tests/examples/build scripts throught artisan

    php artisan vendor:cleanup

And You can now minify all php files throught artisan

    php artisan vendor:minify

#### Thanks [Barry vd. Heuvel](https://github.com/barryvdh) and other [Contributors](https://github.com/goszowski/laravel-vendor-minify/graphs/contributors) for beautiful package to [cleanup Laravel 4.2](https://github.com/barryvdh/laravel-vendor-cleanup)

### License

The Laravel Vendor Minify Command is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
