<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test;

use DateTimeImmutable;
use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Umulmrum\Holiday\Filter\SortByDateFilter;
use Umulmrum\Holiday\Formatter\MarkdownFormatter;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Resolver\IsoResolver;

use function array_map;
use function file_put_contents;

#[AsCommand('test:generate')]
final class GenerateTestCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED);
        $this->addOption('years', 'y', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        [$provider, $years] = $this->getInput($input);
        $data = $this->calculateData($provider, $years);
        $this->outputFile($provider, $data);

        return Command::SUCCESS;
    }

    private function getInput(InputInterface $input): array
    {
        $provider = $input->getArgument('provider');
        $years = $input->getOption('years');
        if ($years === []) {
            $years = [(int) (new DateTimeImmutable())->format('Y')];
        } else {
            $years = array_map('intval', $years);
        }

        return [$provider, $years];
    }

    private function calculateData(string $provider, array $years): string
    {
        $calculator = new HolidayCalculator();
        $sortFilter = new SortByDateFilter();
        $formatter = new MarkdownFormatter();
        $data = '';
        foreach ($years as $index => $year) {
            if ($index > 0) {
                $data .= PHP_EOL;
            }
            $data .= '# ' . $year . PHP_EOL . PHP_EOL;

            /** @var string $formattedHolidays */
            $formattedHolidays = $calculator
                ->calculate($provider, $year)
                ->filter($sortFilter)
                ->format($formatter)
            ;
            $data .= $formattedHolidays;
        }

        return $data;
    }

    private function outputFile(string $provider, string $data): void
    {
        $isoResolver = new IsoResolver();

        /** @var HolidayProviderInterface $resolvedProvider */
        $resolvedProvider = $isoResolver->resolveHolidayProvider($provider);
        $reflectionProvider = new ReflectionClass($resolvedProvider);
        $path = sprintf(
            '%s/Provider/Data/%s-%s.md',
            __DIR__,
            $provider,
            $reflectionProvider->getShortName(),
        );
        file_put_contents($path, $data);
    }
}
