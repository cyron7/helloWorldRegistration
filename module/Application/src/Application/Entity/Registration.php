<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use \Zend\Validator;


/**
 * A Registration object.
 *
 * @ORM\Table(name="Registration")
 * @ORM\Entity()
 */
class Registration implements InputFilterAwareInterface {

    protected $inputFilter;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $pkid;

    /**
     * @ORM\Column(name="First_Name", type="string", nullable=false)
     */
    protected $FirstName;

    /**
     * @ORM\Column(name="Last_Name", type="string", nullable=false)
     */
    protected $LastName;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $Address1;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $Address2;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $City;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $State;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $Country = 'US';

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $Zip;

    public function getPkid()
    {
        return $this->pkid;
    }

    public function setPkid($pkid)
    {
        $this->pkid = $pkid;
    }

    public function getFirstName()
    {
        return $this->FirstName;
    }

    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }

    public function getLastName()
    {
        return $this->LastName;
    }

    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }

    public function getAddress1()
    {
        return $this->Address1;
    }

    public function setAddress1($Address1)
    {
        $this->Address1 = $Address1;
    }

    public function getAddress2()
    {
        return $this->Address2;
    }

    public function setAddress2($Address2)
    {
        $this->Address2 = $Address2;
    }

    public function getCity()
    {
        return $this->City;
    }

    public function setCity($City)
    {
        $this->City = $City;
    }

    public function getState()
    {
        return $this->State;
    }

    public function setState($State)
    {
        $this->State = $State;
    }

    public function getZip()
    {
        return $this->Zip;
    }

    public function setZip($Zip)
    {
        $this->Zip = str_replace('-', '', $Zip);
    }

    public function getCountry()
    {
        return $this->Country;
    }

    public function setCountry($Country)
    {
        if(!empty($Country) && $Country != null) {
            $this->Country = $Country;
        }
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function exchangeArray($data)
    {
        $this->pkid = $data['pkid'];
        $this->FirstName = $data['First_Name'];
        $this->LastName = $data['Last_Name'];
        $this->Address1 = $data['Address1'];
        $this->Address2 = $data['Address2'];
        $this->City = $data['City'];
        $this->State = $data['State'];
        $this->setZip($data['Zip']);
        $this->setCountry($data['Country']);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'pkid',
                'required' => false,
                'filters' => [
                    ['name' => 'Int'],
                ],
            ]);

            $inputFilter->add([
                'name' => 'First_Name',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 50,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 50 characters long'
                            ]
                        ],
                    ],
                    [
                        'name' => 'Alpha',
                        'options' => [
                            'allowWhiteSpace' => false,
                            'messages' => [
                                \Zend\I18n\Validator\Alpha::NOT_ALPHA => 'No numbers allowed',
                                \Zend\I18n\Validator\Alpha::INVALID => 'Invalid name',
                                \Zend\I18n\Validator\Alpha::STRING_EMPTY => 'Cannot be an empty string',
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'Last_Name',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 50,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 50 characters long'
                            ]
                        ],
                    ],
                    [
                        'name' => 'Alpha',
                        'options' => [
                            'allowWhiteSpace' => false,
                            'messages' => [
                                \Zend\I18n\Validator\Alpha::NOT_ALPHA => 'No numbers allowed',
                                \Zend\I18n\Validator\Alpha::INVALID => 'Invalid name',
                                \Zend\I18n\Validator\Alpha::STRING_EMPTY => 'Cannot be an empty string',
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'Address1',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 150,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 150 characters long'
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'Address2',
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 150,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 150 characters long'
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'City',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 100,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 100 characters long'
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'State',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 2,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 2 characters long'
                            ]
                        ],
                    ],
                    [
                        'name' => 'Alpha',
                        'options' => [
                            'allowWhiteSpace' => false,
                            'messages' => [
                                \Zend\I18n\Validator\Alpha::NOT_ALPHA => 'No numbers allowed',
                                \Zend\I18n\Validator\Alpha::INVALID => 'Invalid name',
                                \Zend\I18n\Validator\Alpha::STRING_EMPTY => 'Cannot be an empty string',
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'Zip',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 10,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 5 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 10 characters long'
                            ]
                        ],
                    ],
                    [
                        'name' => 'PostCode',
                        'options' => [
                            'messages' => [
                                \Zend\I18n\Validator\PostCode::INVALID => 'Invalid Zip Code',
                            ]
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'Country',
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 100,
                            'messages' => [
                                Validator\StringLength::TOO_SHORT => 'Must be at least 2 characters long',
                                Validator\StringLength::TOO_LONG => 'No greater than 100 characters long'
                            ]
                        ],
                    ],
                ],
            ]);
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}