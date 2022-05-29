<?php

namespace App\Entity;

use App\Repository\PokerUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokerUserRepository::class)]
/**
 * @SuppressWarnings(PHPMD)
 */
class PokerUser
{
    public function foo(): void
    {
        $baz = 23;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 30)]
    private string $username;

    #[ORM\Column(type: 'string', length: 40)]
    private string $password;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $name;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private string $picture;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $money;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $wins;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $games;

    #[ORM\Column(type: 'string', length: 20)]
    private string $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(?int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getGames(): ?int
    {
        return $this->games;
    }

    public function setGames(?int $games): self
    {
        $this->games = $games;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
