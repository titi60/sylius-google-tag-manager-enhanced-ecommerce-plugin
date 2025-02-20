<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class SyliusGtmEnhancedEcommerceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config['features'] as $feature => $setting) {
            $parameter = sprintf('sylius_gtm_enhanced_ecommerce.features.%s', $feature);

            $container->setParameter($parameter, $setting);

            if ($setting === true || (is_array($setting) && $setting['enabled'] === true)) {
                $loader->load(sprintf('features/%s.yml', $feature));
            }
        }

        if ($config['cache_resolvers']['enabled'] === true) {
            $loader->load('cache_services.yml');

            foreach ($config['cache_resolvers']['ttl'] as $feature => $ttl) {
                $parameter = sprintf('sylius_gtm_enhanced_ecommerce.cache_resolver.%s', $feature);
                $container->setParameter($parameter, $ttl);
            }
        }
    }
}
