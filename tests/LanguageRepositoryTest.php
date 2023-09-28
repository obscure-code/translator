<?php

namespace ObscureCode\Translator\Tests;

use ObscureCode\Translator\Language;
use ObscureCode\Translator\LanguageRepository;
use PHPUnit\Framework\TestCase;

class LanguageRepositoryTest extends TestCase
{
    public function testWithDefaultData(): void
    {
        $language = (new LanguageRepository())
            ->setAvailableLanguages([Language::RU, Language::EN])
            ->readLanguage();

        $this->assertEquals(Language::EN, $language);
    }

    public function testWithGetData(): void
    {
        $_GET['testLangParam'] = Language::RU->value;

        $language = (new LanguageRepository())
            ->setAvailableLanguages([Language::RU, Language::EN])
            ->setGetParameter('testLangParam')
            ->readLanguage();

        $this->assertEquals(Language::RU, $language);
    }

    public function testWithCookieData(): void
    {
        $_COOKIE['testCookieName'] = Language::RU->value;

        $language = (new LanguageRepository())
            ->setAvailableLanguages([Language::RU, Language::EN])
            ->setCookieName('testCookieName')
            ->readLanguage();

        $this->assertEquals(Language::RU, $language);
    }

    public function testWithHttpAcceptLanguage(): void
    {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ru-RU';

        $language = (new LanguageRepository())
            ->setAvailableLanguages([Language::RU, Language::EN])
            ->readLanguage();

        $this->assertEquals(Language::RU, $language);
    }

    public function testWithWrongValues(): void
    {
        $_GET['lang'] = 'unknown';
        $_COOKIE['language'] = 'unknown';
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'unknown';

        $language = (new LanguageRepository())
            ->readLanguage();

        $this->assertEquals(Language::EN, $language);
    }

    public function testWithDefaultValue(): void
    {
        $language = (new LanguageRepository())
            ->setDefaultLanguage(Language::RU)
            ->readLanguage();

        $this->assertEquals(Language::RU, $language);
    }
}
