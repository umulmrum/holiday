<?php

namespace umulmrum\Holiday\Translator;

use Symfony\Component\Translation\TranslatorInterface as SymfonyTranslatorInterface;
use umulmrum\Holiday\Model\Holiday;

class SymfonyBridgeTranslator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslatorInterface
     */
    private $translator;

    /**
     * @param SymfonyTranslatorInterface $translator
     */
    public function __construct(SymfonyTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday)
    {
        return $this->translator->trans($holiday->getName(), [], 'umulmrum_holiday');
    }
}
