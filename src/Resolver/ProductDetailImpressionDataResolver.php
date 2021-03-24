<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory\ProductDetailFactoryInterface;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\Factory\ProductDetailImpressionFactoryInterface;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpressionInterface;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Calculator\ProductVariantPriceCalculatorInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * Class ProductDetailImpressionDataResolver
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver
 */
final class ProductDetailImpressionDataResolver implements ProductDetailImpressionDataResolverInterface
{
    /**
     * @var ProductVariantPriceCalculatorInterface
     */
    private $productVariantPriceCalculator;

    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var ProductDetailImpressionFactoryInterface
     */
    private $productDetailImpressionFactory;

    /**
     * @var ProductDetailFactoryInterface
     */
    private $productDetailFactory;

    /**
     * ProductDetailImpressionDataResolver constructor.
     * @param ProductVariantPriceCalculatorInterface $productVariantPriceCalculator
     * @param ChannelContextInterface $channelContext
     * @param ProductDetailImpressionFactoryInterface $productDetailImpressionFactory
     * @param ProductDetailFactoryInterface $productDetailFactory
     */
    public function __construct(
        ProductVariantPriceCalculatorInterface $productVariantPriceCalculator,
        ChannelContextInterface $channelContext,
        ProductDetailImpressionFactoryInterface $productDetailImpressionFactory,
        ProductDetailFactoryInterface $productDetailFactory
    ) {
        $this->productVariantPriceCalculator = $productVariantPriceCalculator;
        $this->channelContext = $channelContext;
        $this->productDetailImpressionFactory = $productDetailImpressionFactory;
        $this->productDetailFactory = $productDetailFactory;
    }

    /**
     * @inheritdoc
     */
    public function get(ProductInterface $product): ProductDetailImpressionInterface
    {
        $vo = $this->productDetailImpressionFactory->create();

        foreach($this->prepare($product) as $item) {
            $vo->add($item);
        }

        return $vo;
    }

    /**
     * @param ProductInterface $product
     * @return \Generator|ProductDetailInterface[]
     */
    private function prepare(ProductInterface $product): \Generator
    {
        foreach ($product->getVariants() as $variant) {
            yield $this->createProductVariant($variant);
        }
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @return ProductDetailInterface
     */
    private function createProductVariant(ProductVariantInterface $productVariant): ProductDetailInterface
    {
        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();

        $vo = $this->productDetailFactory->create();

        $vo->setName($product->getName());
        $vo->setId($product->getId());
        $vo->setPrice($this->getPrice($productVariant));
        $vo->setCategory($product->getMainTaxon() ? $product->getMainTaxon()->getName() : null);
        $vo->setVariant($productVariant->getCode());

        return $vo;
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @return float
     */
    private function getPrice(ProductVariantInterface $productVariant): float
    {
        return (float)round($this->productVariantPriceCalculator->calculate($productVariant, [
                'channel' => $this->channelContext->getChannel(),
            ]) / 100, 2);
    }
}
