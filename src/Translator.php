<?php

declare(strict_types=1);

namespace ObscureCode\Translator;

use ObscureCode\Translator\Exceptions\MissedTranslationException;

final class Translator
{
    private array $translations = [];
    private Language $language = Language::EN;

    public function setTranslations(array $translations): Translator
    {
        $this->translations = $translations;

        return $this;
    }

    public function setLanguage(Language $language): Translator
    {
        $this->language = $language;

        return $this;
    }

    public function getTranslation(string $key): mixed
    {
        if (isset($this->translations[$key][$this->language->value])) {
            return $this->translations[$key][$this->language->value];
        }

        if (isset($this->translations[$this->language->value][$key])) {
            return $this->translations[$this->language->value][$key];
        }

        throw new MissedTranslationException('Missed translation: ' . $key . ' Language: ' . $this->language->value);
    }
}
