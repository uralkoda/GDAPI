<?php
/*
 * This file is part of the TEST Project.
 *
 * (c) Hamza El Ghoul <elghoulhamzaa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Vatri\GoogleDriveBundle\Service\DriveApiService;

/**
 * Class BaseController
 * @Route("/")
 */
class BaseController extends AbstractController
{

    /**
     * GOOGLEDRIVE
     *  BaseController::googleDrive
     *
     * @Route("/{folderId}", name="google_drive")
     *
     * @param $folderId
     */
    public function googleDrive(DriveApiService $driveApiService, $folderId){

        $isLogged = 1;
        $res = [];

        if($driveApiService->isTokenExpired()){
            $isLogged = 0;
        }else{
            $res = $this->getAllById($driveApiService, $folderId);
        }

        return $this->render(
            'base.html.twig',
            [
                'res' => $res,
                'isLogged' => $isLogged
            ]
        );
    }

    /**
     * LOGIN
     * BaseController::login
     *
     * @Route("/", name="default_index")
     */
    public function login(){

        return $this->render(
            'base.html.twig',
            [
                'isLogged' => 0
            ]
        );
    }

    public function getAllById( $driveApiService, $folderId){
        if ($folderId == 'googleDrive')
            $folderId = null;
        $res = $driveApiService->listFiles($folderId);
        return $res;
    }

}
