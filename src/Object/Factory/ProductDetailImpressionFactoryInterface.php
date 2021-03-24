<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpressionInterface;

/**
 * Interface ProductDetailImpressionFactoryInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory
 */
interface ProductDetailImpressionFactoryInterface
{
    /**
     * @return ProductDetailImpressionInterface
     */
    public function create(): ProductDetailImpressionInterface;
}
