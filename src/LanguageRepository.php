<?php

declare(strict_types=1);

namespace ObscureCode\Translator;

final class LanguageRepository
{
    private string $defaultLanguage = Language::EN;

    /** @var list<string> */
    private array $availableLanguages = [Language::EN];

    private string $getParameter = 'lang';

    private string $cookieName = 'language';

    private int $cookieExpire = 10 * 365 * 24 * 60 * 60;

    public function getLanguage(string $language): string
    {
        return (in_array($language, $this->availableLanguages)) ? $language : $this->defaultLanguage;
    }

    public function readLanguage(): string
    {
        if (isset($_GET[$this->getParameter])) {
            /** @var string $languageFromGet */
            $languageFromGet = $_GET[$this->getParameter];

            $language = $this->getLanguage($languageFromGet);
            $this->saveLanguageToCookie($language);

            return $language;
        }

        if (isset($_COOKIE[$this->cookieName])) {
            return $this->getLanguage($_COOKIE[$this->cookieName]);
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            return $this->getLanguage($language);
        }

        return $this->defaultLanguage;
    }

    public function saveLanguageToCookie(string $language): void
    {
        setcookie(
            $this->cookieName,
            $language,
            time() + $this->cookieExpire,
            '/',
        );
    }

    public function setDefaultLanguage(string $defaultLanguage): LanguageRepository
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    /**
     * @param list<string> $availableLanguages
     */
    public function setAvailableLanguages(array $availableLanguages): LanguageRepository
    {
        $this->availableLanguages = $availableLanguages;

        return $this;
    }

    public function setGetParameter(string $getParameter): LanguageRepository
    {
        $this->getParameter = $getParameter;

        return $this;
    }

    public function setCookieName(string $cookieName): LanguageRepository
    {
        $this->cookieName = $cookieName;

        return $this;
    }

    public function setCookieExpire(int $cookieExpire): LanguageRepository
    {
        $this->cookieExpire = $cookieExpire;

        return $this;
    }
}
