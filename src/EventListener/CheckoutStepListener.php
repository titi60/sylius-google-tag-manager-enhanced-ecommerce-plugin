<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\EventListener;

use Titi60\SyliusGtmEnhancedEcommercePlugin\Resolver\CheckoutStepResolverInterface;
use Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager\CheckoutStepInterface;
use Sylius\Bundle\CoreBundle\Controller\OrderController;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class CheckoutStepListener
 * @package GtmEnhancedEcommerce\EventListener
 */
final class CheckoutStepListener
{
    /**
     * @var CheckoutStepInterface
     */
    private $checkoutStep;

    /**
     * @var CartContextInterface
     */
    private $cartContext;

    /**
     * @var CheckoutStepResolverInterface
     */
    private $checkoutStepResolver;

    /**
     * CheckoutStepListener constructor.
     * @param CheckoutStepInterface $checkoutStep
     * @param CartContextInterface $cartContext
     * @param CheckoutStepResolverInterface $checkoutStepResolver
     */
    public function __construct(
        CheckoutStepInterface $checkoutStep,
        CartContextInterface $cartContext,
        CheckoutStepResolverInterface $checkoutStepResolver
    ) {
        $this->checkoutStep = $checkoutStep;
        $this->cartContext = $cartContext;
        $this->checkoutStepResolver = $checkoutStepResolver;
    }

    /**
     * @param ControllerEvent $event
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        // Only perform on master request
        if (!$event->isMasterRequest()) {
            return;
        }

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        // Should be order controller, else we are for sure not in the checkout
        if (!$controller[0] instanceof OrderController) {
            return;
        }

        // Resolve step
        $step = $this->checkoutStepResolver->resolve($controller[1], $event->getRequest());
        if ($step === null) {
            return;
        }

        // Add E-Commerce data
        $this->checkoutStep->addStep($this->cartContext->getCart(), $step);
    }
}
