<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\Articulo;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/{pagina}", name="home")
     */
    public function homeAction(Request $request, $pagina = 1)
    {
        $ArticuloRepository = $this->getDoctrine()->getRepository(Articulo::class);
        $articulos = $ArticuloRepository->paginaArticulos($pagina);
        //$articulos = $ArticuloRepository->findAll();
        // replace this example code with whatever you need
        return $this->render('home/home.html.twig', array('articulos' => $articulos));
    }

    /**
     * @Route("/blog/", name="blog")
     */
    public function blogAction(Request $request)
    {
        //traer articulos de la base de datos por el repositorio
        // replace this example code with whatever you need
        return $this->render('home/blog.html.twig');
    }

    /**
     * @Route("/posts/", name="posts")
     */
    public function postsAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('home/posts.html.twig');
    }

    /**
     * @Route("/articulo/{id}", name="articulo")
     */
    public function articuloAction(Request $request, $id = null)
    {
        if ($id != null) {
            $articulorepository = $this->getDoctrine()->getRepository(Articulo::class);
            $articulo = $articulorepository->find($id);
            return $this->render('home/articulo.html.twig', array('articulo' => $articulo));
        } else {
            return $this->redirectToRoute('home');
        }

        // replace this example code with whatever you need

    }

    /**
     * @Route("/registro/", name="registro")
     */
    public function registroAction(Request $request, UserPasswordEncoderInterface $passwordEncoder,$id=null)
    {
        if ($id) {
            $usuariorepository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $usuariorepository->find($id);
        } else {
            $usuario = new Usuario();
        }
        //construyendo el formulario
        $form = $this->createForm(UsuarioType::class, $usuario);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);

            //username = email
            $usuario->setUsername($usuario->getEmail());

            //roles
            $usuario->setRoles(array('ROLE_USER'));

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');
        }
        return $this->render(
            'home/registro.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/login/", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // replace this example code with whatever you need
        return $this->render('home/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/gestion/misUsuarios/", name="misUsuarios")
     */
    public function misUsuariosAction(Request $request)
    {
        $usuariorepository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuarios = $usuariorepository->findAll();
        return $this->render('gestion/misUsuarios.html.twig', array("usuarios" => $usuarios));
    }

     /**
     * @Route("/eliminarUsuario/{id}", name="eliminarUsuario")
     */
    public function eliminarUsuarioAction(Request $request, $id = null)
    {
        if ($id) {
            //buscar 
            $Usuarioepository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $Usuarioepository->find($id);
            //borrar
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }
            return $this->redirectToRoute('misArticulos');
        
    }



}
