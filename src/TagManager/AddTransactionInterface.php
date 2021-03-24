<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager;

use Sylius\Component\Core\Model\OrderInterface;

/**
 * Interface AddTransactionInterface
 * @package Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager
 */
interface AddTransactionInterface
{
    /**
     * @param OrderInterface $order
     */
    public function addTransaction(OrderInterface $order): void;
}
