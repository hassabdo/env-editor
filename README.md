# A tool to let user modify any exposed environment variables in Laravel Nova

When this tool is added to Nova, you can modify the app environment variables with a config file indicating exposed environment variables.

![screenshot of the backup tool](https://github.com/hassabdo/env-editor/raw/master/Screenshot.png)

## Installation
The package is not available in packagist library because it is still on test.

You can install the package manually in a Laravel app that uses [Nova](https://nova.laravel.com) by dowloading this repostory and adding it to dependencies in your composer.json file.

You need to publish the configuration file to set exposed variables via : 

```bash
php artisan vendor:publish --tag=env-editor-config
```
The config must have the following structure :
- name : The name of the variable as existing in the .env file.
- label : The name of the variable as showen in the form.

```php
    return [

        /*
        |--------------------------------------------------------------------------
        | Exposed Env variables
        |--------------------------------------------------------------------------
         */

        'exposed_variables' => [
            # name => label
        ],
    ];
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

You can also restrict the usage of this tool to specific users.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        (new \Hassen\EnvEditor\EnvEditorTool)->canSee(function ($request) {
            return $request->user()->isSuperAdmin();
        }),
    ];
}
```
The package can be translated to different languages. You need to add the following to lang.json in the app lang folder:

```json

    "Your env file has been saved!": "Vos variables d'environnement ont été enregistré!",
    "Edit Environment File": "Modifier les variables d'environnement",
    "Caution": "Attention",
    "Save File": "Enregistrer",
    "Be careful when modifying, it may affect existing integrations.": "Soyez prudent lors de la modification, cela peut affecter les intégrations existantes.",
    "ENV Settings": "Variables d'environnement"

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
