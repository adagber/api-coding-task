<?php declare(strict_types=1);

namespace App\Security\Domain\Model;

final class User implements UserInterface, \JsonSerializable
{
    private int $id;

    private string $email;

    private string $hash;

    private \DateTimeImmutable $registeredAt;

    private array $roles = [];

    public function __construct(string $email, string $hash, array $roles = ['ROLE_USER'])
    {
        $this->email = $email;
        $this->hash = $hash;
        $this->registeredAt = new \DateTimeImmutable('now');
        $this->roles = $roles;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;
        return $this;
    }

    public function deleteRole(string $role): self
    {
        $key = array_search($role, $this->roles);
        if ($key !== false) {
            unset($this->roles[$key]);
        }

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function hasAnyRoles(array $roles): bool
    {
        foreach ($roles as $role){

            if($this->hasRole($role)){
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(string $password, PasswordHasherInterface $passwordHasher): bool
    {
        return $passwordHasher->checkHash($password, $this->hash);
    }

    /**
     * {@inheritdoc}
     */
    public function changePassword(string $password, PasswordHasherInterface $passwordHasher): void
    {
        $this->hash = $passwordHasher->hash($password);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'registered_at' => $this->getRegisteredAt()
                ->format(\DateTimeImmutable::ATOM)
        ];
    }
}