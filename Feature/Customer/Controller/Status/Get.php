<?php
namespace Feature\Customer\Controller\Status;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Customer\Model\Session;

class Get extends \Magento\Customer\Controller\AbstractAccount implements HttpGetActionInterface
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param JsonHelper $jsonHelper
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        JsonHelper $jsonHelper,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->session = $customerSession;
        $this->jsonHelper = $jsonHelper;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    public function execute(){
        $customer = $this->customerRepository->getById($this->session->getCustomerId());

        $result = array();
        if($customer->getId()) {
            $result['status'] = $customer->getCustomAttribute('status')->getValue();
        } else {
            $result['status'] = false;
        }

        $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($result)
        );

        return;
    }
}
