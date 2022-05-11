# Opentelemetry Laminas Module

A Laminas module that wraps the [OpenTelementry SDK](https://github.com/open-telemetry/opentelemetry-php) for PHP.

## Installation

```bash
composer require soockee/laminas-opentelemetry
```

## Examples

To run the example use the build in PHP server

```bash
cd example/skeleton_example
php -S 0.0.0.0:8080 -t public
```

## Tests

```bash
make test
```

## Contributing

This project uses the [3 Musketeers pattern](https://3musketeers.io/docs/patterns.html#make)

In a nutshell, a user calls a Make target which then delegates the Task to be executed in a Container to Docker or Compose