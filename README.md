# Skippy - The lightweight PHP AMQP Messager

## Getting started

### Installation

You can install this package via composer using this command:

`composer require jungehaie/skippy`

### Laravel 5.2+

1. Register the Service Provider

```php
// config/app.php
'providers' => [
    ...
    Skippy\Providers\SkippyServiceProvider::class,
]
```

2. Publish the basic configuration

`php artisan vendor:publish --provider="Skippy\Providers\SkippyServiceProvider"`

3. Register an alias (optional)

```php
// config/app.php
'aliases' => [
    ...
    'Skippy'   => Skippy\Facades\Skippy::class,
],
```

### Lumen 5.2+

1. Register the Service Provider

```php
// bootstrap/app.php
$app->register(Skippy\Providers\SkippyServiceProvider::class);
```

2. Add a configuration file at config/skippy.php

You can copy the content of the base configuration file and adjust it to your needs.

3. Register the configuration to be loaded

```php
// bootstrap/app.php
$app->configure('skippy');
```

4. Register an alias (optional)

```php
// bootstrap/app.php
class_alias(Skippy\Skippy::class, 'Skippy');
```

## Examples

```php
$profile = $this->createMagicalProfile();

$message = [
    'id'      => Uuid::generate(4)->string,
    'cids'    => [
        Uuid::generate(4)->string,
    ],
    'type'    => 'new-magical-profile',
    'version' => '1.0.0',
    'body'    => $profile,
];

Skippy::send($message)->publish('magical-profile-created');
```

## Contributing

## Contributing

### Pull Requests

- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)**

- **Document any changes** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Create feature branches** - Use `git checkout -b my-new-feature`

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.


## License

skippy is distributed under the terms of the [MIT license](https://github.com/krenor/skippy/blob/master/LICENSE.md)
