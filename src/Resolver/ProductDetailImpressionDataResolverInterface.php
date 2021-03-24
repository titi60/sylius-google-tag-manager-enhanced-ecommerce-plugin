<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpressionInterface;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * Interface ProductDetailImpressionDataResolverInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver
 */
interface ProductDetailImpressionDataResolverInterface
{
    /**
     * @return ProductDetailImpressionInterface
     */
    public function get(ProductInterface $product): ProductDetailImpressionInterface;
}
