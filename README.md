# ambersive/ebinterface

[![Maintainability](https://api.codeclimate.com/v1/badges/979720a6c6bec2f5237b/maintainability)](https://codeclimate.com/github/AMBERSIVE/laravel-ebinterface/maintainability) [![Build Status](https://travis-ci.org/AMBERSIVE/laravel-ebinterface.svg?branch=master)](https://travis-ci.org/AMBERSIVE/laravel-ebinterface)

Laravel ebInterface integration. This package can create create fully valid ebInterface invoices. We are currently working on the integration of the webservice.

Changes between versions will be tracked in the [CHANGELOG](CHANGELOG.md).

## Installation

```bash
composer require ambersive/ebinterface
```

### Configs

```bash
php artisan vendor:publish --tag=ebinterface
```

Please notice that every config key is accessable via environment variables. Some of them should be set for better invoice creation experience.

## Documentation
This package is based on the invoice standard [EBINTERFACE 5.0](https://www.wko.at/service/netzwerke/ebInvoice_5p0.pdf).
The generated xml out can be tested by uploading to [TEST-Upload](https://test.erechnung.gv.at/erb?p=tec_test_upload&locale=de_AT). This package provides various test scenarios. Nevertheless please feel free to ask anything if you find something unclear.
If you want to learn to create an invoice read the following [tutorial](docs/tutorial.md).

## Feedback

Please feel free to give us feedback or any improvement suggestions.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Manuel Pirker-Ihl via [manuel.pirker-ihl@ambersive.com](mailto:manuel.pirker-ihl@ambersive.com). All security vulnerabilities will be promptly addressed.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
