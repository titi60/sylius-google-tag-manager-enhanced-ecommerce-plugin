<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpression;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpressionInterface;

/**
 * Class ProductDetailImpressionFactory
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory
 */
final class ProductDetailImpressionFactory implements ProductDetailImpressionFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(): ProductDetailImpressionInterface
    {
        return new ProductDetailImpression();
    }
}
