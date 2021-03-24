<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver\Cache;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Object\ProductDetailImpressionInterface;
use Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver\ProductDetailImpressionDataResolverInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class ProductDetailImpressionCachedDataResolver
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver\Cache
 */
final class ProductDetailImpressionCachedDataResolver implements ProductDetailImpressionDataResolverInterface
{
    /**
     * @var ProductDetailImpressionDataResolverInterface
     */
    private $productDetailImpressionDataResolver;

    /**
     * @var AdapterInterface
     */
    private $cacheAdapter;

    /**
     * @var int
     */
    private $cacheTtl;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * ProductDetailImpressionCachedDataResolver constructor.
     * @param ProductDetailImpressionDataResolverInterface $productDetailImpressionDataResolver
     * @param AdapterInterface $cacheAdapter
     * @param int $cacheTtl
     * @param string $cacheKey
     */
    public function __construct(
        ProductDetailImpressionDataResolverInterface $productDetailImpressionDataResolver,
        AdapterInterface $cacheAdapter,
        int $cacheTtl,
        string $cacheKey
    ) {
        $this->productDetailImpressionDataResolver = $productDetailImpressionDataResolver;
        $this->cacheAdapter = $cacheAdapter;
        $this->cacheTtl = $cacheTtl;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @inheritDoc
     */
    public function get(ProductInterface $product): ProductDetailImpressionInterface
    {
        $cacheKey = sprintf('%s.%d', $this->cacheKey, $product->getId());
        $cache = $this->cacheAdapter->getItem($cacheKey);

        if (!$cache->isHit()) {
            $data = $this->productDetailImpressionDataResolver->get($product);

            $cache
                ->set($data)
                ->expiresAfter($this->cacheTtl);

            $this->cacheAdapter->save($cache);
        }

        return $cache->get();
    }
}
