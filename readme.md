# Easy settings for WordPress Demo

This repository contains a WordPress demo plugin for the composer package [Easy Settings for WordPress](https://github.com/threadi/easy-settings-for-wordpress). It is intended to show the possibilities of the plugin. It is not intended to be used actively in a productive system. You are welcome to use the programming as a template for your own use of Easy settings for WordPress.

## Hint

This demo uses also beta versions of Easy Settings for WordPress.

## Use the demo

1. Download the actual release ZIP (not the source ZIP).
2. Install it in your WordPress and activate it.
3. Navigate to Settings > Demo Settings to view the demo. You can test it as you wish.

## Use it for development of the demo plugin

1. Checkout the repository in your development environment in the plugin directory or download the actual source ZIP.
2. Run `composer install` to get the sources.
3. Go to the backend of your development environment and activate the plugin.
4. Navigate to Settings > Demo Settings to view the demo.

### Release

#### from local environment with ant

1. increase the version number in _build/build.properties_.
2. execute the following command in _build/_: `ant build`
3. after that you will find a zip file in the release directory, which could be used in WordPress to install it.

#### on GitHub

1. Create a new tag with the new version number.
2. The release zip will be created by GitHub action.

## Use it for development of the composer package Easy Settings for WordPress

1. Checkout the repository in your development environment in the plugin directory or download the actual source ZIP.
2. Checkout the repository https://github.com/threadi/easy-settings-for-wordpress in your hostings main directory (where **wp-admin** and **wp-config.php** are located).
3. Run: `chmod 755 composer.sh` 
4. Run `./composer.sh`
5. Go to the backend of your development environment and activate the plugin.
6. You are now able to develop on Easy Settings for WordPress and test the changes with the demo plugin.

## Check for WordPress Coding Standards

### Initialize

`composer install`

### Run

`vendor/bin/phpcs --standard=ruleset.xml .`

### Repair

`vendor/bin/phpcbf --standard=ruleset.xml .`

## Check for WordPress VIP Coding Standards

Hint: this check runs against the VIP-GO-platform which is not our target for this plugin. Many warnings can be ignored.

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/vendor/* --standard=WordPress-VIP-Go .`

## Check PHP compatibility

`vendor/bin/phpcs -p crypt-for-wordpress-demo.php --standard=PHPCompatibilityWP`

## Analyse with PHPStan

`vendor/bin/phpstan analyse`