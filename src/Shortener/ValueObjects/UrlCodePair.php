<?php

namespace App\Shortener\ValueObjects;

class UrlCodePair
{
    protected string $code;
    protected string $url;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    /**
     * @param string $code
     * @param string $url
     */
    public function __construct(string $code, string $url)
    {
        $this->code = $code;
        $this->url = $url;
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    public function setCreatedAt(): void
    {
        $createdAt = new \DateTime('now');
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(): void
    {
        $updatedAt = new \DateTime('now');
        $this->updatedAt = $updatedAt;
    }


    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }


}