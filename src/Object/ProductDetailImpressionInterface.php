<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Object;

/**
 * Interface ProductDetailImpressionDataInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Object
 */
interface ProductDetailImpressionInterface
{
    /**
     * @param ProductDetailInterface $productDetail
     */
    public function add(ProductDetailInterface $productDetail): void;

    /**
     * @return array
     */
    public function toArray(): array;
}
