<?php
namespace Product\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProductCategoryTable
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
        $rowset = $this->tableGateway->select(['id_category' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveProduct(ProductCategory $ProductCategory)
    {
        $data = [
            'id_category' => $ProductCategory->id_category,
            'id_cat_top'  => $ProductCategory->id_cat_top,
            'name'  => $ProductCategory->name,
            'description'  => $ProductCategory->description,
            'image'  => $ProductCategory->image,
            'orden'  => $ProductCategory->orden,
            'status'  => $ProductCategory->status,
        ];

        $id = (int) $ProductCategory->id_category;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getProductCategory($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update ProductCategory with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id_category' => $id]);
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['id_category' => (int) $id]);
    }
}