<?php declare(strict_types=1);

namespace Titi60\SyliusGtmEnhancedEcommercePlugin\EventListener;

use Titi60\SyliusGtmEnhancedEcommercePlugin\TagManager\AddTransactionInterface;
use App\Controller\Resources\OrderController;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class ThankYouListener
 * @package GtmEnhancedEcommerce\EventListener
 */
final class ThankYouListener
{

    /**
     * @var AddTransactionInterface
     */
    private $transactionService;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * ThankYouListener constructor.
     * @param AddTransactionInterface $transactionService
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        AddTransactionInterface $transactionService,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->transactionService = $transactionService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param  $event
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

        // We only want the SyliusOrderController
        if (!$controller[0] instanceof OrderController) {
            return;
        }

        // Now check the method, should be
        if ($controller[1] !== 'thankYouAction') {
            return;
        }

        // Find Order ID
        $orderId = $event->getRequest()->getSession()->get('sylius_order_id');
        if ($orderId === null) {
            return;
        }

        // Find Order
        $order = $this->orderRepository->find($orderId);
        if (!$order instanceof OrderInterface) {
            return;
        }

        // Add E-Commerce data
        $this->transactionService->addTransaction($order);
    }
}
