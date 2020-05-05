# BookingModule

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Create Booking list

## Installation

Via Composer

``` bash
$ composer require zdrojowa/booking-module
```

- Add module BookingModule in config/selene.php

``` bash
'modules' => [
    BookingModule::class,
],

'menu-order' => [
    'BookingModule',
],
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zdrojowa/booking-module.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zdrojowa/booking-module.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zdrojowa/booking-module
[link-downloads]: https://packagist.org/packages/zdrojowa/booking-module
[link-author]: https://github.com/zdrojowa
[link-contributors]: ../../contributors
