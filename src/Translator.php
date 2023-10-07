<?php

declare(strict_types=1);

namespace ObscureCode\Translator;

use ObscureCode\Translator\Exceptions\MissedTranslationException;

final class Translator
{
    private array $translations = [];
    private string $language = Language::EN;

    public function setTranslations(array $translations): Translator
    {
        $this->translations = $translations;

        return $this;
    }

    public function setLanguage(string $language): Translator
    {
        $this->language = $language;

        return $this;
    }

    public function getTranslation(string $key): mixed
    {
        if (isset($this->translations[$key][$this->language])) {
            return $this->translations[$key][$this->language];
        }

        if (isset($this->translations[$this->language][$key])) {
            return $this->translations[$this->language][$key];
        }

        throw new MissedTranslationException('Missed translation: ' . $key . ' Language: ' . $this->language);
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
}
