<?php

namespace Scraping\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Scraping
{
    public $id_product;
    public $id_brand;
    public $id_category;
    public $name;
    public $description;
    public $stock;
    public $status;
    public $outstanding;
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id_product     = !empty($data['id_product']) ? $data['id_product'] : null;
        $this->id_brand = !empty($data['id_brand']) ? $data['id_brand'] : null;
        $this->id_category  = !empty($data['id_category']) ? $data['id_category'] : null;
        $this->name  = !empty($data['name']) ? $data['name'] : null;
        $this->description  = !empty($data['description']) ? $data['description'] : null;
        $this->stock  = !empty($data['stock']) ? $data['stock'] : null;
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
            'name' => 'id_product',
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
            'id_product' => $this->id_product,
            'id_brand' => $this->id_brand,
            'id_category' => $this->id_category,
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'status' => $this->status,
            'outstanding' => $this->outstanding
        ];    
    }
}