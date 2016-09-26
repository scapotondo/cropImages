<?php

namespace ImageBundle\Controller;

use ImageBundle\Entity\Imagen;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Image;

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
        $em = $this->getDoctrine()->getManager();
        $subir = new Imagen();

        $imagen = $this->get('subirImagen');
//        var_dump($request->request->all());
        $imagenes = $imagen->getImages();

        if ($imagenes == false) {
            var_dump('mal'); exit;
        }else{
            foreach ($imagenes as $imagen) {
                $newImagen = $this->get('subirImagen')->saveFile($imagen['output']['data'], $imagen['input']['name'], 'images');
//                var_dump($newImagen['name']); exit;

                $subir->setNombre($newImagen['name']);
                $em->persist($subir);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('upload'));

    }
}
