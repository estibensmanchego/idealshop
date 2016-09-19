<?php

namespace Product\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Product
{
    public $id_category;
    public $id_cat_top;
    public $name;
    public $description;
    public $image;
    public $orden;
    public $status;
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id_category     = !empty($data['id_category']) ? $data['id_category'] : null;
        $this->id_cat_top = !empty($data['id_cat_top']) ? $data['id_cat_top'] : null;
        $this->name  = !empty($data['name']) ? $data['name'] : null;
        $this->description  = !empty($data['description']) ? $data['description'] : null;
        $this->image  = !empty($data['image']) ? $data['image'] : null;
        $this->orden  = !empty($data['orden']) ? $data['orden'] : null;
        $this->status  = !empty($data['status']) ? $data['status'] : null;
        $this->outstanding  = !empty($data['outstanding']) ? $data['outstanding'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id_category',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 350,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function getArrayCopy()
    {
        return [
            'id_category' => $this->id_category,
            'id_cat_top' => $this->id_cat_top,
            'name' => $this->name,
            'description' => $this->description,
            'orden' => $this->orden,
            'status' => $this->status
        ];    
    }
}