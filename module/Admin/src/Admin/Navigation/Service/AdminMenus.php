<?php

namespace Admin\Navigation\Service;

use Zend\ServiceManager\ServiceLocator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminMenus extends DefaultNavigationFactory {

    protected $menuTable;

    protected function getName() {
        return 'admin';
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator) {
        if (null === $this->pages) {
            $this->menuTable = $this->getMenuTable($serviceLocator);
            $menus = $this->menuTable->getNavigationArray(2, '', array(), false);

            // esto se genera desde la base de datos
            $configuration['navigation'][$this->getName()] = $menus;

            if (!isset($configuration['navigation'])) {
                throw new Exception\InvalidArgumentException('Could not find navigation configuration key');
            }
            if (!isset($configuration['navigation'][$this->getName()])) {
                throw new Exception\InvalidArgumentException(sprintf(
                        'Failed to find a navigation container by the name "%s"', $this->getName()
                ));
            }

            $application = $serviceLocator->get('Application');
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $router = $application->getMvcEvent()->getRouter();
            $pages = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
            // 
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
    }

    // Método para obtener la tabla menu del modelo
    public function getMenuTable($serviceLocator) {
        if (!$this->menuTable) {
            $this->menuTable = $serviceLocator->get('Smeagol\Model\MenuTable');
        }

        return $this->menuTable;
    }

}