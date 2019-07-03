# Crawler stuff

A small set of things for the web scraping and crawling

## Arg

Usage:
```php
$lines = Arg::cli(1, 'input.txt')
    ->file()
    ->readFile()
    ->splitBy(PHP_EOL)
    ->val();
```