<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager;

use Sylius\Component\Order\Model\OrderInterface;

/**
 * Interface CheckoutStepInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager
 */
interface CheckoutStepInterface
{
    /**
     * @param OrderInterface $order
     * @param int $step
     */
    public function addStep(OrderInterface $order, int $step): void;
}
