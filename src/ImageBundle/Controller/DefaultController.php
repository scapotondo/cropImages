<?php

namespace ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/upload", name="upload")
     * @Template()
     */
    public function indexAction()
    {

        return $this->render('ImageBundle:Default:index.html.twig');
    }

    /**
     * @Route("/create", name="create_imagen")
     */
    public function createAction(Request $request){
        $imagen = $this->get('subirImagen');
        var_dump($request->request->all());
        $imagenes = $imagen->getImages();

        if ($imagenes == false) {
            var_dump('mal'); exit;
        }else{
            foreach ($imagenes as $imagen) {
                $this->get('subirImagen')->saveFile($imagen['output']['data'], $imagen['input']['name'], '');
            }
        }

        return $this->redirect($this->generateUrl('upload'));

    }
}
