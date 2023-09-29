# Example

```php
use ObscureCode\Translator\Language;
use ObscureCode\Translator\LanguageRepository;

$language = (new LanguageRepository())
    ->setAvailableLanguages([Language::DE, Language::EN])
    ->setDefaultLanguage(Language::DE)
    ->readLanguage();

$translator = (new Translator())
    ->setTranslations([
        'good' => [
            Language::DE->value => 'gut',
            Language::EN->value => 'good',
        ],
        'bad' => [
            Language::DE->value => 'schlecht',
            Language::EN->value => 'bad',
        ],
    ]);

$translation = $translator
    ->setLanguage(Language::DE)
    ->getTranslation('bad');

echo $translation; //schlecht
```

another way:

```php
$translator = (new Translator())
    ->setTranslations([
        Language::DE->value => [
            'good' => 'gut',
            'bad' => 'schlecht',
        ],
        Language::EN->value => [
            'good' => 'good',
            'bad' => 'bad',
        ],
    ]);

$translation = $translator
    ->setLanguage(Language::DE)
    ->getTranslation('good');

echo $translation; //gut
```

There are some popular languages in `ObscureCode\Translator\Language`, but you can use any:

```php
$language = (new LanguageRepository())
    ->setAvailableLanguages([Language::DE, Language::EN, 'valyrian'])
```

# Local development

```
docker build --tag translator .
docker run --detach -v "$(pwd):/app" --name=translator translator
docker exec -it translator /bin/bash

composer install
cd /app/vendor/bin/
./phpunit /app/tests/
./phpcs /app/src/
./phpstan analyze /app/src/
./psalm
```