<?php

namespace App\Shortener;

use App\Entity\User;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeRepository;
use App\Shortener\ValueObjects\UrlCodePair;
use App\Entity\UrlCodePair as UrlCodePairEntity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class CodePairRepository implements ICodeRepository
{

    protected ObjectRepository $cpRepository;
    protected ObjectManager $em;
    public function __construct(protected ManagerRegistry $doctrine)
    {
        $this->em = $this->doctrine->getManager();
        $this->cpRepository = $this->doctrine->getRepository(UrlCodePairEntity::class);
    }


    /**
     * @inheritDoc
     */
    public function saveEntity(UrlCodePair $urlCodePairVO): bool
    {
        try {
            $result = true;
            $codePair = new UrlCodePairEntity($urlCodePairVO->getUrl(), $urlCodePairVO->getCode());
            //date('Y-m-d H:i:s');
            $this->em->persist($codePair);
            $this->em->flush();
        }   catch (\Throwable) {
                $result = false;
        }
            return $result;
    }

    /**
     * @inheritDoc
     */
    public function codeIsset(string $code): bool
    {
        return (bool) $this->cpRepository->findOneBy(['code' => $code]);
    }


    public function getUrlByCode(string $code): string
    {
        try {
            /**
            * @var UrlCodePairEntity $codePair
            */
            $codePair = $this->cpRepository->findOneBy(['code' => $code]);
            return $codePair->getUrl();
        }  catch (\Throwable) {
            throw new DataNotFoundException('Url not found');
        }
    }


    public function getCodeByUrl(string $url): string
    {
        try {
            /**
            * @var UrlCodePairEntity $codePair
            */
            $codePair = $this->cpRepository->findOneBy(['url' => $url]);
            return $codePair->getCode();
        } catch (\Throwable)  {
            throw new DataNotFoundException('Code not found');
        }
    }
}