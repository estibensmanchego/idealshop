<?php
namespace Product\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProductTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getProduct($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id_product' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveProduct(Product $Product)
    {
        $data = [
            'id_brand' => $Product->id_brand,
            'id_category'  => $Product->id_category,
            'name'  => $Product->name,
            'description'  => $Product->description,
            'stock'  => $Product->stock,
            'status'  => $Product->status,
            'outstanding'  => $Product->outstanding,
        ];

        $id = (int) $Product->id_product;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getProduct($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update Product with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id_product' => $id]);
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['id_product' => (int) $id]);
    }
}