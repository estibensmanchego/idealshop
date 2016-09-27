<?php
namespace Product\Controller\Factory;

use Product\Controller\ProductController;

class ProductControllerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ProductController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controllerPluginManager = $serviceLocator;
        $serviceManager = $controllerPluginManager->get('ServiceManager');
        $productTable = $serviceManager->get('Product\Model\ProductTable');
        return new  ProductController($productTable);
    }
}