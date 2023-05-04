<?php

declare(strict_types=1);

namespace Services;

use Entity\Car;
use model\Tables\CarsModel;

class CarService
{
    private CarsModel $_cartModel;
    private array $_toSend = [];

    public function __construct()
    {
        $this->_cartModel = new CarsModel();
    }

    public function run(string $method, array $arg)
    {
        switch ($method) {
            case 'GET':
                if (isset($arg['id']) && ctype_digit($arg['id'])) {
                    return $this->get((int)$arg['id']);
                }
                return $this->getList();
                break;
            case 'POST':
                return $this->insert();
                break;
            case 'PUT':
                return $this->update();
                break;
            case 'DELETE':
                return $this->delete();
                break;
        }
    }

    public function get(?int $id): array
    {
        return $this->_cartModel->select([
            'no' => $id
        ]);
    }

    public function getList(): array
    {
        return $this->_cartModel->select([
            'no' => null
        ]);


    }

    public function insert(): void
    {

    }

    public function update(): void
    {

    }

    public function delete(): void
    {

    }

}