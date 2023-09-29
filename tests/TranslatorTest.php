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
                Language::RU => [
                    'rhododendron' => 'рододендрон',
                    'kalmiopsis' => 'кальмиопсис',
                ],
                Language::EN => [
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
                    Language::RU => 'рододендрон',
                    Language::EN => 'rhododendron',
                ],
                'kalmiopsis' => [
                    Language::RU => 'кальмиопсис',
                    Language::EN => 'kalmiopsis',
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
                    Language::RU => 'рододендрон',
                ],
            ]);

        $this->expectException(MissedTranslationException::class);

        $translator
            ->setLanguage(Language::EN)
            ->getTranslation('rhododendron');
    }
}
