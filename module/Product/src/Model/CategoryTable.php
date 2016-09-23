<?php
namespace Product\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CategoryTable
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

    public function getCategory($id)
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

    public function saveCategory(Category $Category)
    {
        $data = [
            'id_category' => $Category->id_category,
            'id_cat_top'  => $Category->id_cat_top,
            'name'  => $Category->name,
            'description'  => $Category->description,
            'image'  => $Category->image,
            'orden'  => $Category->orden,
            'status'  => $Category->status,
        ];

        $id = (int) $Category->id_category;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getCategory($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update Category with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id_category' => $id]);
    }

    public function deleteCategory($id)
    {
        $this->tableGateway->delete(['id_category' => (int) $id]);
    }
}