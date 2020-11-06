<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Resolver;

use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final class ResolverHandler implements ResolverHandlerInterface
{
    /**
     * @var ProviderResolverInterface[]
     */
    private $resolvers;

    /**
     * @param ProviderResolverInterface[] $resolvers
     */
    public function __construct(array $resolvers)
    {
        foreach ($resolvers as $resolver) {
            $this->addResolver($resolver);
        }
    }

    private function addResolver(ProviderResolverInterface $providerResolver): void
    {
        $this->resolvers[] = $providerResolver;
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $identifier
     *
     * @return HolidayProviderInterface[]
     *
     * @throws \InvalidArgumentException
     */
    public function resolve($identifier): array
    {
        if (\is_array($identifier)) {
            $resolved = [];
            foreach ($identifier as $id) {
                $resolved[] = $this->doResolve($id);
            }

            return $resolved;
        }

        return [$this->doResolve($identifier)];
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $identifier
     *
     * @throws \InvalidArgumentException
     */
    private function doResolve($identifier): HolidayProviderInterface
    {
        if ($identifier instanceof HolidayProviderInterface) {
            return $identifier;
        }

        if (false === \is_string($identifier)) {
            throw new \InvalidArgumentException('Argument must either be an instance of HolidayProviderInterface,
                a string containing a class name or an array of these types. Got: '.\print_r($identifier, true));
        }

        foreach ($this->resolvers as $resolver) {
            $resolved = $resolver->resolveHolidayProvider($identifier);
            if (null !== $resolved) {
                return $resolved;
            }
        }

        throw new \InvalidArgumentException('Could not resolve holiday provider for: '.$identifier);
    }
}
