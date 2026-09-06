<div class="filament-hidden">

![Laravel Beehiiv](https://raw.githubusercontent.com/jeffersongoncalves/laravel-beehiiv/main/art/jeffersongoncalves-laravel-beehiiv.png)

</div>

# Laravel Beehiiv

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-beehiiv.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-beehiiv)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-beehiiv/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-beehiiv/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-beehiiv/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-beehiiv/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-beehiiv.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-beehiiv)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-beehiiv.svg?style=flat-square)](LICENSE.md)

A PHP/Laravel client for the [Beehiiv](https://www.beehiiv.com/) REST API v2. Covers publications, subscriptions, posts, segments, automations and referral programs through a simple, typed API built on Laravel's `Http` client.

## Features

- Publications: list, get
- Subscriptions: list, get, create, update, delete
- Posts: list, get, create, delete
- Segments: list, get
- Automations: list, get
- Referral Program: get
- Optional default publication scope (via config) so you don't have to pass a publication ID to every call
- Throws `BeehiivException` (with the original API error body) on any non-2xx response
- Throws `InvalidArgumentException` before hitting the API when a required field/argument is missing

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-beehiiv
```

Publish the config file:

```bash
php artisan vendor:publish --tag=beehiiv-config
```

Set your Beehiiv credentials in `.env`:

```env
BEEHIIV_API_KEY=your-api-key
BEEHIIV_PUBLICATION_ID=pub_00000000-0000-0000-0000-000000000000
```

Both values are found under **Settings > Integrations > API** in your Beehiiv account. `BEEHIIV_PUBLICATION_ID` is optional — set it if most of your calls target a single publication, otherwise pass a publication ID explicitly to each method.

## Configuration

```php
// config/beehiiv.php
return [
    'api_key' => env('BEEHIIV_API_KEY', ''),
    'publication_id' => env('BEEHIIV_PUBLICATION_ID'),
    'default_limit' => env('BEEHIIV_DEFAULT_LIMIT', 10),
];
```

## Usage

The package is resolved via the `Beehiiv` facade or by injecting `JeffersonGoncalves\Beehiiv\Beehiiv`. Each resource is exposed as a method returning a dedicated resource class.

### Publications

Publications are not scoped to a publication ID — this resource lists your publications and looks one up:

```php
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

$publications = Beehiiv::publications()->list();

$publication = Beehiiv::publications()->get('pub_00000000-0000-0000-0000-000000000000');
```

### Subscriptions

Every other resource is scoped to a publication. Pass `$publicationId` explicitly, or omit it to use `beehiiv.publication_id` from config:

```php
// List (supports email, status, tier, cursor, expand filters)
$subscriptions = Beehiiv::subscriptions()->list(filters: ['email' => 'jane@example.com']);

$subscription = Beehiiv::subscriptions()->get('sub_00000000-0000-0000-0000-000000000000');

$subscription = Beehiiv::subscriptions()->create([
    'email' => 'jane@example.com',
    'reactivate_existing' => false,
    'send_welcome_email' => true,
    'utm_source' => 'newsletter',
]);

Beehiiv::subscriptions()->update('sub_00000000-0000-0000-0000-000000000000', ['tier' => 'premium']);

Beehiiv::subscriptions()->delete('sub_00000000-0000-0000-0000-000000000000');

// Or target a different publication explicitly
Beehiiv::subscriptions()->list(publicationId: 'pub_11111111-1111-1111-1111-111111111111');
```

### Posts

```php
$posts = Beehiiv::posts()->list(filters: ['status' => 'confirmed']);

$post = Beehiiv::posts()->get('post_00000000-0000-0000-0000-000000000000');

$post = Beehiiv::posts()->create([
    'title' => 'Hello World',
    'subtitle' => 'A short subtitle',
    'status' => 'draft',
]);

Beehiiv::posts()->delete('post_00000000-0000-0000-0000-000000000000');
```

### Segments, Automations and Referral Program

```php
Beehiiv::segments()->list();
Beehiiv::segments()->get('seg_00000000-0000-0000-0000-000000000000');

Beehiiv::automations()->list();
Beehiiv::automations()->get('aut_00000000-0000-0000-0000-000000000000');

Beehiiv::referralProgram()->get();
```

### Error handling

Any non-2xx API response throws `JeffersonGoncalves\Beehiiv\Exceptions\BeehiivException`, which exposes the decoded error body:

```php
use JeffersonGoncalves\Beehiiv\Exceptions\BeehiivException;

try {
    Beehiiv::subscriptions()->get('does-not-exist');
} catch (BeehiivException $e) {
    logger()->error($e->getMessage(), $e->errorBody());
}
```

Missing required fields/arguments (e.g. `email` on `subscriptions()->create()`, `title` on `posts()->create()`, or a publication ID when none is configured) throw `InvalidArgumentException` before any HTTP call is made.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
