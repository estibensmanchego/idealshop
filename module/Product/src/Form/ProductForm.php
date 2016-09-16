<?php
namespace Product\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('product');

        $this->add([
            'name' => 'id_product',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'id_brand',
            'type' => 'select',
            'options' => [
                'empty_option' => '-- Selecciona una marca --',
                'value_options' => [
                    '1' => 'Marca 1',
                 ],
            ]
        ]);
        $this->add([
            'name' => 'id_category',
            'type' => 'select',
            'options' => [
                'empty_option' => '-- Selecciona una categoría --',
                'value_options' => [
                    '2' => 'Categoria 1',
                 ],
            ]
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre',
            ],
        ]);
        $this->add([
            'name' => 'description',
            'type' => 'textarea',
            'options' => [
                'label' => 'Descripcion',
            ],
            'attributes' => [
                'rows' => 5
            ]
        ]);
        $this->add([
            'name' => 'stock',
            'type' => 'text',
            'options' => [
                'label' => 'Stock',
            ],
        ]);
        $this->add([
            'name' => 'status',
            'type' => 'checkbox',
            'required' => false,
            'options' => [
                'use_hidden_element' => false,
                'checsked_value' => '1',
                'unchecked_value' => '0'
            ],
            'attributes' => [
                 'value' => '1'
            ]
        ]);
        $this->add([
            'name' => 'outstanding',
            'type' => 'checkbox',
            'required' => false,
            'options' => [
                'use_hidden_element' => false,
                'checsked_value' => '1',
                'unchecked_value' => '0'
            ],   
            'attributes' => [
                 'value' => '1'
            ]     
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}