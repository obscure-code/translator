<?php

namespace ObscureCode\Translator\Tests;

use ObscureCode\Translator\Exceptions\MissedTranslationException;
use ObscureCode\Translator\Language;
use ObscureCode\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
    public function testWithFirstTypeData(): void
    {
        $translator = (new Translator())
            ->setTranslations([
                Language::RU->value => [
                    'rhododendron' => 'рододендрон',
                    'kalmiopsis' => 'кальмиопсис',
                ],
                Language::EN->value => [
                    'rhododendron' => 'rhododendron',
                    'kalmiopsis' => 'kalmiopsis',
                ]
            ]);

        $this->assertEquals(
            'рододендрон',
            $translator
                ->setLanguage(Language::RU)
                ->getTranslation('rhododendron'),
        );

        $this->assertEquals(
            'кальмиопсис',
            $translator
                ->getTranslation('kalmiopsis'),
        );

        $this->assertEquals(
            'rhododendron',
            $translator
                ->setLanguage(Language::EN)
                ->getTranslation('rhododendron'),
        );

        $this->assertEquals(
            'kalmiopsis',
            $translator
                ->getTranslation('kalmiopsis'),
        );
    }

    public function testWithSecondTypeData(): void
    {
        $translator = (new Translator())
            ->setTranslations([
                'rhododendron' => [
                    Language::RU->value => 'рододендрон',
                    Language::EN->value => 'rhododendron',
                ],
                'kalmiopsis' => [
                    Language::RU->value => 'кальмиопсис',
                    Language::EN->value => 'kalmiopsis',
                ],
            ]);

        $this->assertEquals(
            'рододендрон',
            $translator
                ->setLanguage(Language::RU)
                ->getTranslation('rhododendron'),
        );

        $this->assertEquals(
            'кальмиопсис',
            $translator
                ->getTranslation('kalmiopsis'),
        );

        $this->assertEquals(
            'rhododendron',
            $translator
                ->setLanguage(Language::EN)
                ->getTranslation('rhododendron'),
        );

        $this->assertEquals(
            'kalmiopsis',
            $translator
                ->getTranslation('kalmiopsis'),
        );
    }

    public function testMissedTranslation(): void
    {
        $translator = (new Translator())
            ->setTranslations([
                'rhododendron' => [
                    Language::RU->value => 'рододендрон',
                ],
            ]);

        $this->expectException(MissedTranslationException::class);

        $translator
            ->setLanguage(Language::EN)
            ->getTranslation('rhododendron');
    }
}
