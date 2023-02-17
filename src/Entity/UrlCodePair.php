<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity()]
#[ORM\Table(name: 'url_codes')]
class UrlCodePair
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;


    #[ORM\Column(length: 255)]
    private string $url;


    #[ORM\Column(length: 12)]
    private string $code;

    #[ORM\Column(type: Types::INTEGER)]
    private int $counter = 0;

//    #[ORM\Column(name: 'createdAt', type: 'string', nullable: false)]
//    private string $createdAt;
//
//    #[ORM\Column(name: 'updatedAt', type: 'string', nullable: false)]
//    private string $updatedAt;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private \DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, updatable: true)]
    private \DateTime $updatedAt;


    /**
     * @param string $code
     * @param string $url
     */
    public function __construct(string $url, string $code)
    {
        $this->code = $code;
        $this->url = $url;
        $this->setCreatedAt();  //date('Y-m-d H:i:s');
        $this->setUpdatedAt();
        $a = 1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(): void
    {
        $createdAt = new \DateTime('now');
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(): void
    {
        $updatedAt = new \DateTime('now');
        $this->updatedAt = $updatedAt;
    }




    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    public function incrementCounter(): void
    {
        $this->counter++;
    }

}