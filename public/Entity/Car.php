<?php

declare(strict_types=1);

namespace Entity;

use DateTime;
use Exception;
use Interfaces\ToArrayInterface;

class Car implements ToArrayInterface
{
    private int $no;
    private string $registration_number;
    private string $car_brand;
    private string $car_model;
    private DateTime $ctime;
    private DateTime $mtime;

    public function getNo(): int
    {
        return $this->no;
    }

    public function setNo(int $no): void
    {
        $this->no = $no;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registration_number;
    }

    public function setRegistrationNumber(string $registration_number): void
    {
        $this->registration_number = $registration_number;
    }

    public function getCarBrand(): string
    {
        return $this->car_brand;
    }

    public function setCarBrand(string $car_brand): void
    {
        $this->car_brand = $car_brand;
    }

    public function getCarModel(): string
    {
        return $this->car_model;
    }

    public function setCarModel(string $car_model): void
    {
        $this->car_model = $car_model;
    }

    public function getCtime(): DateTime
    {
        return $this->ctime;
    }

    /**
     * @throws Exception
     */
    public function setCtime(?string $ctime): void
    {
        if(!empty($ctime)) {
            $this->ctime = new DateTime($ctime);
        } else {
            $this->ctime = '';
        }
    }

    public function getMtime(): DateTime
    {
        return $this->mtime;
    }

    /**
     * @throws Exception
     */
    public function setMtime(string $mtime): void
    {
        if(!empty($mtime)) {
            $this->mtime = new DateTime($mtime);
        } else {
            $this->mtime = '';
        }
    }

    public function toArray(): array
    {
        $toReturn = [];
        foreach ($this as $element => $value) {
            if(!is_object($value)) {
                $toReturn[$element] = $value;
            } elseif($value instanceof DateTime) {
                $toReturn[$element] = $value->format('Y-m-d H:i');
            }
        }
        return $toReturn;
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }
}