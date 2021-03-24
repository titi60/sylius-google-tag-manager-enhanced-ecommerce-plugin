<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface CheckoutStepResolverInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver
 */
interface CheckoutStepResolverInterface
{
    /**
     * @param string $method
     * @param Request $request
     * @return int|null
     */
    public function resolve(string $method, Request $request): ?int;
}
