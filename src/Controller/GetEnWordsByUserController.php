<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\EnWord;
use App\Repository\EnWordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetEnWordsByUserController extends AbstractController
{

    public function __construct(private EnWordRepository $enRepository)
    {

    }

    public function __invoke(Request $request)
    {
        /** @var User */
        $user = $this->getUser();
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 10);
        
        return $this->enRepository->getCollectionByUser($user, $page, $limit );
    }
}
