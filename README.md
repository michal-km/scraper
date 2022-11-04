# Scraper

Scraper is a simple Symfony console application for extracting data from websites. This software is a technology demonstrator and should not be used for real-life applications without a few improvements like JS support or proxy API. It can, however, be a very good base for future projects.

## Requirements

- PHP version 8.0 or higher,
- an Internet connection (obviously).

## Installation

```
git clone https://github.com/michal-km/scraper.git
cd scraper
chmod +x scraper
composer install
```

## Use

### Scrape a website and display the JSON result
```
./scraper get https://wltest.dns-systems.net/
```
or, for the default website (the same as above):
```
./scraper get
```
Should any issues arise, please look into `scraper.log` file for more information.

### Display usage information
```
scraper
```

On the Windows system please precede the command with php.exe, f.e.:
```
php.exe scrapper
```

## Testing

In order to not abuse the live website, all tests are performed on a dummy HTML file (saved from the real site), located at tests/Resources.

Tests are using a different configuration file, config/services.test.yml

```
vendor/bin/phpunit tests
```

## TL;DR

Scraping a website needs relatively few tools and this project could be easily made in "plain" PHP. It would meet the specification and certainly, the data would be scraped - today. I'd like to create software that looks into the future. What if the page's layout changes? What if the URL changes?
Maybe more interesting data will appear on the site, how we're going to scrape it all?

To address these potential issues, I decided to use Symfony components, but without the whole Symfony skeleton and even without Symfony's kernel. I began with the Symfony console application with all its benefits, including ready-made command and argument processor. Then I added a dependency injection component with a configuration (service.yml) loader and the default simple logger.

The dependency injection allowed me to design a flexible "engine" based on Snippets - an easily changeable piece of code, responsible for extracting a single parameter. The interesting thing is, the only thing to do to scrape new data is to create a new Snippet class in src\Scraper\Snippets folder. There is no need to register it anywhere or call it from another class - it would be auto-discovered and loaded.

### Extending

The main piece of the scraping engine is a Snippet. It is a simple class, extending \App\Scraper\Snippets\AbstractSnippet, that finds a DOM element in a given piece of HTML document, extracts a single value, and stores it under a predefined name.

Example:

```
public const OPTION_NAME = "discount";
public const OPTION_REQUIRED = true; // default behaviour is to fall silently 
// when the data could not be scraped; with this line Snippet will generate \Exception.

protected function parse($node) : void
    {
        $this->value = $node->filter('p[style="color: red"]')->text();
    }
```

For core scraping functions I used an old, but still very good Goutte PHP web crawler.

## Copyright

This software is released into the public domain under the GPL-3 license.