<?php declare(strict_types=1);

namespace App\Lotr\Application\DTO;

trait LoadDataFromArrayTrait
{
    static public function create(): self
    {
        return new self();
    }

    public static function createFromArray(?array $data): self
    {
        if(!$data){
            return self::create();
        }
        return self::create()->fromArray($data);
    }

    public function fromArray(array $data): self
    {

        foreach ($data as $property => $value){

            if(property_exists(self::class, $property)){

                $this->$property = $value === null ? NullValue::create() : $value;
            }
        }

        return $this;
    }
}