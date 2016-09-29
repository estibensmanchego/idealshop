<?php
namespace Scraping\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ScrapingTable
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

    public function getScraping($id)
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

    public function saveScraping(Scraping $Scraping)
    {
        $data = [
            'id_brand' => $Scraping->id_brand,
            'id_category'  => $Scraping->id_category,
            'name'  => $Scraping->name,
            'description'  => $Scraping->description,
            'stock'  => $Scraping->stock,
            'status'  => $Scraping->status,
            'outstanding'  => $Scraping->outstanding,
        ];

        $id = (int) $Scraping->id_product;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getScraping($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update Scraping with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id_product' => $id]);
    }

    public function deleteScraping($id)
    {
        $this->tableGateway->delete(['id_product' => (int) $id]);
    }
}