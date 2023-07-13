<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\EnWord;
use App\Entity\FrWord;
use App\Repository\EnWordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Error;


class CreateEnWordController extends AbstractController
{
    private $manager;
    private $enRepository;

    public function __construct(EntityManagerInterface $entityManager, EnWordRepository $enRepository)
    {   
        $this->manager = $entityManager;
        $this->enRepository = $enRepository;
    }


    public function __invoke(EnWord $data): EnWord
 {
       // dd($data);
        $isExist = $this->enRepository->findOneBy(['content' => $data->getContent(), 'user' => $this->getUser()]);
        
        if($isExist){
            throw new Error("Already exist");
        }
        else{
            $frWord = new FrWord();
            $frWord->setContent($data->wordFr);
            $data->addFrWord($frWord);
            $data->setUser($this->getUser());
            if($data->frDescription and trim($data->frDescription) != ""){
                $frWord->setDescription($data->frDescription);
            }
            $this->manager->persist($frWord);
            $this->manager->persist($data);

            $this->manager->flush();
            return $data;
        }
    }
}
