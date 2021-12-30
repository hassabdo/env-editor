# A tool to let user modify any exposed environment variables in Laravel Nova

When this tool is added to Nova, you can modify the app environment variables with a config file indicating exposed environment variables.

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require hassen/env-editor
```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \Hassen\EnvEditor\EnvEditorTool,
    ];
}
```

## Usage

Click on the "ENV Settings" menu item in your Nova app to see the tool provided by this package.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email abd.hassen@gmail.com instead of using the issue tracker.

## Credits

- [HASSEN ABDELJAOUED](https://github.com/hassabdo)

## License

Not yet received
