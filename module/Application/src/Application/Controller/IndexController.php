<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    /**
     * @var EntityManager $em
     */
    protected $em;

    private function getEntityManager(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
        $entityName = 'Application\Entity\Registration';

        /**
         * @var \Application\Entity\Registration $entityResult
         */
        $entityResult = $this->getEntityManager()->getRepository($entityName)->findAll();

        var_dump($entityResult);die('end');

        return new ViewModel();
    }

    public function adminReportAction() {
        return new ViewModel();
    }

    public function getAdminReportAction() {
        $entityName = 'Application\Entity\Registration';

        /**
         * @var \Application\Entity\Registration $entityResult
         */
        $entityResult = $this->getEntityManager()->getRepository($entityName)->findAll();

        /** @var \Application\Entity\Registration[] $registeredUsers */
        $registeredUsers = [];
        /** @var \Application\Entity\Registration $result */
        foreach($entityResult as $result) {
            $registeredUsers[] = $result->getArrayCopy();
        }

        return new JsonModel(['registeredUsers' => $registeredUsers]);
    }
}
