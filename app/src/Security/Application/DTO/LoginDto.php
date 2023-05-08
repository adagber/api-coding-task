<?php declare(strict_types=1);

namespace App\Security\Application\DTO;

final class LoginDto
{
    private ?string $email;
    private ?string $password;

    use LoadDataFromArrayTrait;

    public function __construct(){

    }


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }
}