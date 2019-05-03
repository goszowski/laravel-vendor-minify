## Laravel Vendor Cleanup and Minify Commands

### Remove tests & documentation from the vendor dir. Minify all php files in the vendor dir

Require this package:

    composer require goszowski/laravel-vendor-minify

You can now remove all the docs/tests/examples/build scripts throught artisan

    php artisan vendor:cleanup

And You can now minify all php files throught artisan

    php artisan vendor:minify


### License

The Laravel Vendor Minify Command is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
