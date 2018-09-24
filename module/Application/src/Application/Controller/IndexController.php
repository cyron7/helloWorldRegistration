<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Registration;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\XmlRpc\Value\Integer;

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
        return new ViewModel();
    }

    public function adminReportAction() {
        return new ViewModel();
    }
    
    public function getConformationPageAction() {
        $request = $_GET;
        if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $entityName = 'Application\Entity\Registration';
            $id = $_GET['id'];
            /**
             * @var \Application\Entity\Registration $entityResult
             */
            $entityResult = $this->getEntityManager()->getRepository($entityName)->findBy(['pkid' => $id]);
            if($entityResult != false) {
                $result = $entityResult[0];
                $name = $result->getFirstName() . ' ' . $result->getLastName();
                $address = '<br>' . $result->getAddress1() . '<br>' .
                    $result->getCity() . ', ' .
                    $result->getState() . ' ' .
                    $result->getZip();
                return new ViewModel(['name' => $name, 'address' => $address]);
            }
        }
        return new ViewModel();
    }

    public function sendRegistrationInfoAction() {
        $request = $this->getRequest()->getPost()->toArray();
        $registration = new Registration();
        $inputFilter = $registration->getInputFilter();
        $inputFilter->setData($request);
        $saveFailed = false;
        $messages = [];
        if($inputFilter->isValid()) {
            $registration->exchangeArray($request);
            $this->getEntityManager()->persist($registration);
            try{
                $this->getEntityManager()->flush();
            }catch (\Exception $e){
                $saveFailed = true;
                $messages['System Fail'][] = 'Failed to save the registration';
            }
        } else {
            $saveFailed = true;
            $messages['Input Validation Error'] = $inputFilter->getMessages();
        }

        return new JsonModel(['success' => !$saveFailed, 'id' => $registration->getPkid(), 'messages' => $messages]);
    }

    public function getAdminReportAction() {
        $entityName = 'Application\Entity\Registration';

        /**
         * @var \Application\Entity\Registration $entityResult
         */
        $entityResult = $this->getEntityManager()->getRepository($entityName)->findBy([], ['Created' => 'DESC']);

        /** @var \Application\Entity\Registration[] $registeredUsers */
        $registeredUsers = [];
        /** @var \Application\Entity\Registration $result */
        foreach($entityResult as $result) {
            $registeredUsers[] = $result->getArrayCopy();
        }

        return new JsonModel(['registeredUsers' => $registeredUsers]);
    }

    public function getRegistrationFormAction() {
        return new ViewModel();
    }
}
