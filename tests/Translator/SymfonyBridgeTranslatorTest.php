<?php


namespace umulmrum\Holiday\Translator;


use DateTime;
use Symfony\Component\Translation\TranslatorInterface;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Model\Holiday;

class SymfonyBridgeTranslatorTest extends HolidayTestCase
{
    /**
     * @var SymfonyBridgeTranslator
     */
    private $translator;
    /**
     * @var TranslatorInterface
     */
    private $symfonyTranslator;

    /**
     * @test
     * @dataProvider getTranslateData
     *
     * @param string $name
     */
    public function it_should_send_names_to_the_translator($name)
    {
        $this->givenASymfonyBridgeTranslator();
        $this->whenTranslateIsCalled($name);
        $this->thenTheSymfonyTranslatorShouldBeCalled($name);
    }

    private function givenASymfonyBridgeTranslator()
    {
        $this->symfonyTranslator = $this->prophesize('\Symfony\Component\Translation\TranslatorInterface');
        $this->translator = new SymfonyBridgeTranslator($this->symfonyTranslator->reveal());
    }

    /**
     * @param $name
     */
    private function whenTranslateIsCalled($name)
    {
        $this->translator->translateName(new Holiday($name, new DateTime('2016-01-01')));
    }

    /**
     * @param string $name
     */
    private function thenTheSymfonyTranslatorShouldBeCalled($name)
    {
        $this->symfonyTranslator->trans($name, [], 'umulmrum_holiday')->shouldHaveBeenCalled();
    }

    /**
     * @return array
     */
    public function getTranslateData()
    {
        return [
            [
                'name',
            ],
        ];
    }
}