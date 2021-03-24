<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetail;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailInterface;

final class ProductDetailFactory implements ProductDetailFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(): ProductDetailInterface
    {
        return new ProductDetail();
    }
}
