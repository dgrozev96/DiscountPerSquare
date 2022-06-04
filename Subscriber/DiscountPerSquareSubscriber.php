<?php

namespace DiscountPerSquare\Subscriber;

use Enlight\Event\SubscriberInterface;

class DiscountPerSquareSubscriber implements SubscriberInterface
{

    private string $pluginName;
    private string $pluginDirectory;
    private \Enlight_Template_Manager $templateManager;

    public function __construct($pluginName, $pluginDirectory, \Enlight_Template_Manager $templateManager)
    {
        $this->pluginName = $pluginName;
        $this->pluginDirectory = $pluginDirectory;
        $this->templateManager = $templateManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'preCheckout',
            'Enlight_Controller_Action_PreDispatch' => 'onBackend'
        ];
    }

    public function onBackend()
    {
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }

    public function preCheckout(\Enlight_Controller_ActionEventArgs $args)
    {
        $basket = $args->getSubject()->getBasket();
        $config = $this->getConfig();

        if (sizeof($basket)) {

            foreach ($basket['content'] as $article) {
                if ($article['unitID'] == $config['unit']) {
                    if (($article['quantity'] * $article['purchaseunit'] >= $config['value'])) {

                    }
                }
            }
        }


    }

    private function getConfig()
    {
        return Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName($this->pluginName, Shopware()->Shop());
    }
}