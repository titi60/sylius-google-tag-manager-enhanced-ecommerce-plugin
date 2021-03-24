<?php declare(strict_types=1);

namespace Tests\Titi60\SyliusGtmEnhancedEcommercePlugin\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Titi60\SyliusGtmEnhancedEcommercePlugin\DependencyInjection\SyliusGtmEnhancedEcommerceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class SyliusGtmEnhancedEcommerceExtensionTest extends TestCase
{
    public function testMinimalConfig(): void
    {
        $container = $this->getContainer();
        $extension = new SyliusGtmEnhancedEcommerceExtension();

        $config = [];

        $extension->load(['sylius_gtm_enhanced_ecommerce' => $config], $container);

        $this->assertTrue(
            $container->getParameter('sylius_gtm_enhanced_ecommerce.features.purchases')
        );

        $this->assertTrue(
            $container->getParameter('sylius_gtm_enhanced_ecommerce.features.product_impressions')
        );

        $this->assertTrue(
            $container->getParameter('sylius_gtm_enhanced_ecommerce.features.product_detail_impressions')
        );

        $this->assertTrue(
            $container->getParameter('sylius_gtm_enhanced_ecommerce.features.product_clicks')
        );

        $this->assertTrue(
            $container->getParameter('sylius_gtm_enhanced_ecommerce.features.cart')
        );

        $conf = $container->getParameter('sylius_gtm_enhanced_ecommerce.features.checkout');
        $this->assertTrue($conf['enabled']);

        $this->assertFalse(
            $container->hasParameter('sylius_gtm_enhanced_ecommerce.cache_resolver.product_detail_impressions')
        );
    }

    public function testWithCacheResolver(): void
    {
        $container = $this->getContainer();
        $extension = new SyliusGtmEnhancedEcommerceExtension();

        $config = [
            'cache_resolvers'=>true,
        ];
        $extension->load(['sylius_gtm_enhanced_ecommerce' => $config], $container);

        $this->assertEquals(
            3600,
            $container->getParameter('sylius_gtm_enhanced_ecommerce.cache_resolver.product_detail_impressions')
        );
    }

    private function getContainer(): ContainerBuilder
    {
        return new ContainerBuilder(new ParameterBag([
            'kernel.debug' => false,
            'kernel.bundles' => [],
            'kernel.cache_dir' => sys_get_temp_dir(),
            'kernel.environment' => 'test',
            'kernel.root_dir' => __DIR__.'/../../src/',
        ]));
    }
}
