# [Guzzle](http://docs.guzzlephp.org/en/latest/) middleware for [Clockwork](https://github.com/itsgoingd/clockwork) logging

[![Build Status](https://img.shields.io/travis/keerill/guzzle-clockwork/3.x?style=flat-square)](https://travis-ci.org/hannesvdvreken/guzzle-clockwork)
[![Latest Stable Version](https://img.shields.io/packagist/v/keerill/guzzle-clockwork?style=flat-square)](https://packagist.org/packages/hannesvdvreken/guzzle-clockwork)
[![Code Quality](https://img.shields.io/scrutinizer/g/keerill/guzzle-clockwork?style=flat-square)](https://scrutinizer-ci.com/g/hannesvdvreken/guzzle-clockwork/)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/keerill/guzzle-clockwork?style=flat-square)](https://scrutinizer-ci.com/g/hannesvdvreken/guzzle-clockwork/)
[![Total Downloads](https://img.shields.io/packagist/dt/keerill/guzzle-clockwork?style=flat-square)](https://packagist.org/packages/hannesvdvreken/guzzle-clockwork)
[![License](https://img.shields.io/github/license/keerill/guzzle-clockwork?style=flat-square)](#license)

Guzzle middleware for logging requests clockwork's timeline so you can view the timeline in your browser's developer tools.

![Developer tools timeline](images/clockwork-timeline.png "Developer tools timeline")

## Usage

Composer install

```bash
composer require keerill/guzzle-clockwork
```

```php
// First you need a Clockwork object
$clockwork = \Clockwork\Support\Vanilla\Clockwork::init();

// Create the Guzzle middleware
$middleware = new \GuzzleHttp\Profiling\Middleware(
    new \GuzzleHttp\Profiling\Clockwork\Profiler($clockwork->getClockwork()->timeline())
);

// Then you need to add it to the Guzzle HandlerStack
$stack = \GuzzleHttp\HandlerStack::create();

$stack->unshift($middleware);

$client = new \GuzzleHttp\Client(['handler' => $stack]);

$client->get('https://httpbin.org/status/418');
```

Depending on your integration of Clockwork, make sure that you call `$clockwork->requestProcessed();` before you output your page.

### Laravel

If you are using Laravel, use the included service providers to add
the subscriber to every Guzzle Client.

```php
'providers' => [
    ...
    \Clockwork\Support\Laravel\ClockworkServiceProvider::class,
    \GuzzleHttp\Profiling\Clockwork\GuzzleClockworkServiceProvider::class,
],
```

Be sure to create every client (type hint with `GuzzleHttp\ClientInterface` or `GuzzleHttp\Client`) via the IoC container.

## Contributing

Feel free to make a pull request. Please try to be as
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
compliant as possible. Fix Code Style quickly by running `vendor/bin/php-cs-fixer fix`. Give a good description of what is supposed to be added/changed/removed/fixed.

### Testing

To test your code before pushing, run the unit test suite.

```bash
vendor/bin/phpunit
```

## License

[MIT](LICENSE.md)
