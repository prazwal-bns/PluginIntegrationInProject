# Integrate MultiSourceFileUpload Package into Laravel Project

## Overview

You've created a Laravel/Filament package at `packages/MultiSourceFileUpload` that adds file upload functionality. Here's how to integrate it into your main Laravel application for development and learning.

## Understanding Your Package Structure

Your package includes:

- **Service Provider**: `MultiSourceFileUploadServiceProvider.php` - Registers the package with Laravel
- **Component**: `MultiSourceFileUpload.php` - The main Filament component
- **Config**: `multi-source-file-upload.php` - Configuration options
- **Namespace**: `Przwl\MultiSourceFileUpload` - Your package's PHP namespace

## Integration Steps

### Step 1: Configure Composer to Recognize Local Package

Add a `repositories` section to your root `composer.json` (lines 8-23) to tell Composer about your local package:

```json
"repositories": [
    {
        "type": "path",
        "url": "./packages/MultiSourceFileUpload",
        "options": {
            "symlink": true
        }
    }
]
```

This creates a symlink so changes to your package are immediately available without reinstalling.

### Step 2: Require Your Package

Add your package to the `require` section in root `composer.json`:

```json
"require": {
    "php": "^8.2",
    "filament/filament": "4.0",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1",
    "przwl/multi-source-file-upload": "@dev"
}
```

The `@dev` tells Composer to use the development version from your local path.

### Step 3: Install the Package

Run Composer to install/link your package:

```bash
composer update przwl/multi-source-file-upload
```

### Step 4: Publish Configuration (Optional)

If you want to customize the config, publish it:

```bash
php artisan vendor:publish --tag=multi-source-file-upload-config
```

This copies `config/multi-source-file-upload.php` to your main app's `config` directory.

### Step 5: Verify Installation

The package should auto-register via Laravel's package discovery (configured in your package's `composer.json` extra section). Verify by checking:

```bash
php artisan about
```

Look for your service provider in the list.

## How to Use Your Package

### Using the Tab Macro

In any Filament form, you can now use the `monitorFileUpload()` macro:

```php
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

Tabs::make('Upload Options')
    ->tabs([
        Tab::make('File Upload')
            ->monitorFileUpload()
            ->schema([
                // your file upload fields
            ]),
        Tab::make('URL Upload')
            ->schema([
                // your URL upload fields
            ]),
    ])
```

### Accessing Configuration

```php
$pollInterval = config('multi-source-file-upload.poll_interval');
$labels = config('multi-source-file-upload.labels');
```

## Development Workflow

**Making Changes:**

1. Edit files in `packages/MultiSourceFileUpload/src/`
2. Changes are immediately available (due to symlink)
3. If you add new classes, run `composer dump-autoload`

**Testing:**

- Create test files in your main app that use the package
- Iterate on the package code as needed

## Key Learning Points

1. **PSR-4 Autoloading**: Maps namespace `Przwl\MultiSourceFileUpload\` to `src/` directory
2. **Service Provider**: Laravel's way of bootstrapping packages (registering services, publishing assets)
3. **Package Discovery**: The `extra.laravel.providers` section in composer.json automatically registers your provider
4. **Config Merging**: `mergeConfigFrom()` provides defaults while allowing users to override
5. **Path Repository**: Composer feature that lets you develop packages locally alongside your app

## Common Issues & Solutions

**Package not found**: Run `composer dump-autoload`

**Changes not reflected**: Ensure symlink option is true, or run `composer update`

**Class not found**: Check namespace matches between composer.json and actual PHP files

**Config not working**: Make sure you've published or merged the config properly

## Next Steps for Learning

- Add more components to your package
- Write PHPUnit tests in `packages/MultiSourceFileUpload/tests/`
- Add migrations if you need database tables
- Explore publishing views and assets
- Eventually publish to Packagist for public use