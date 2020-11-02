<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use Umulmrum\Holiday\Model\Holiday;

/**
 * FilterInverter takes another subclass of AbstractFilter and retains all elements the inner filter would reject and
 * vice versa.
 */
final class FilterInverter extends AbstractFilter
{
    /**
     * @var AbstractFilter
     */
    private $inner;

    public function __construct(AbstractFilter $inner)
    {
        $this->inner = $inner;
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        return !$this->inner->isIncluded($holiday);
    }
}
