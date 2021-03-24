<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailInterface;

/**
 * Interface ProductDetailFactoryInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory
 */
interface ProductDetailFactoryInterface
{
    /**
     * @return ProductDetailInterface
     */
    public function create(): ProductDetailInterface;
}
