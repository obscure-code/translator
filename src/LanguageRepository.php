<?php

declare(strict_types=1);

namespace ObscureCode\Translator;

final class LanguageRepository
{
    private Language $defaultLanguage = Language::EN;

    /** @var list<Language> */
    private array $availableLanguages = [Language::EN];

    private string $getParameter = 'lang';

    private string $cookieName = 'language';

    private int $cookieExpire = 10 * 365 * 24 * 60 * 60;

    public function getLanguage(string $language): Language
    {
        $language = Language::tryFrom($language);

        if ($language === null) {
            return $this->defaultLanguage;
        }
        if (!in_array($language, $this->availableLanguages)) {
            return $this->defaultLanguage;
        }

        return $language;
    }

    public function readLanguage(): Language
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

    public function saveLanguageToCookie(Language $language): void
    {
        setcookie(
            $this->cookieName,
            $language->value,
            time() + $this->cookieExpire,
            '/',
        );
    }

    public function setDefaultLanguage(Language $defaultLanguage): LanguageRepository
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    /**
     * @param list<Language> $availableLanguages
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
