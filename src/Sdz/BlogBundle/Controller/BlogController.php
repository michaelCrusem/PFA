<?php
 
// src/Sdz/BlogBundle/Controller/BlogController.php
 
namespace Sdz\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sdz\BlogBundle\Form\ArticleType;
use Sdz\BlogBundle\Entity\Article;

class BlogController extends Controller
{
   public function indexAction($page)
  {
    $articles = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('SdzBlogBundle:Article')
                     ->getArticles(3, $page); // 3 articles par page : c'est totalement arbitraire !
 
    // On ajoute ici les variables page et nb_page à la vue
    return $this->render('SdzBlogBundle:Blog:index.html.twig', array(
      'articles'   => $articles,
      'page'       => $page,
      'nombrePage' => ceil(count($articles)/3)
    ));
  }
 
  public function voirAction(Article $article)
  {
    // À ce stade, la variable $article contient une instance de la classe Article
    // Avec l'id correspondant à l'id contenu dans la route !
 
    // On récupère ensuite les articleCompetence pour l'article $article
    // On doit le faire à la main pour l'instant car la relation est unidirectionnelle
    // C'est-à-dire que $article->getArticleCompetences() n'existe pas !
    $listeArticleCompetence = $this->getDoctrine()
                                   ->getManager()
                                   ->getRepository('SdzBlogBundle:ArticleCompetence')
                                   ->findByArticle($article->getId());
 
    return $this->render('SdzBlogBundle:Blog:voir.html.twig', array(
      'article'                 => $article,
      'listeArticleCompetence'  => $listeArticleCompetence
    ));
  }
 
  public function ajouterAction()
  {
    $article = new Article;
    $form = $this->createForm(new ArticleType, $article);
    $request = $this->get('request');
    if( $request->getMethod() == 'POST' )
    {
      $form->bind($request);
      if( $form->isValid() )
      {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($article);
        $em->flush();
        return $this->redirect( $this->generateUrl('sdzblog_accueil') );
      }
    }
    return $this->render('SdzBlogBundle:Blog:ajouter.html.twig', array(
      'form' => $form->createView(),
    ));
  }
 
  public function modifierAction($id)
  {
    $article = $this->getDoctrine()
                    ->getRepository('Sdz\BlogBundle\Entity\Article')
                    ->find($id);
    $form = $this->createForm(new ArticleType, $article);
    $request = $this->get('request');
    if( $request->getMethod() == 'POST' )
    {
      $form->bind($request);
      if( $form->isValid() )
      {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($article);
        $em->flush();
        return $this->redirect( $this->generateUrl('sdzblog_accueil') );
      }
    }
    return $this->render('SdzBlogBundle:Blog:modifier.html.twig', array(
      'form' => $form->createView(),
    ));
  }
 
  public function supprimerAction($id)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()
               ->getEntityManager();
 
    // On récupère l'entité correspondant à l'id $id
    $article = $em->getRepository('SdzBlogBundle:Article')
                  ->find($id);
     
    // Si l'article n'existe pas, on affiche une erreur 404
    if ($article == null) {
      throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
    }
 
    if ($this->get('request')->getMethod() == 'POST') {
      // Si la requête est en POST, on supprimera l'article
       
      $this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');
 
      // Puis on redirige vers l'accueil
      return $this->redirect( $this->generateUrl('sdzblog_accueil') );
    }
 
    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('SdzBlogBundle:Blog:supprimer.html.twig', array(
      'article' => $article
    ));
  }
 
  public function menuAction($nombre)
  {
    $liste = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('SdzBlogBundle:Article')
                  ->findBy(
                    array(),          // Pas de critère
                    array('date' => 'desc'), // On tri par date décroissante
                    $nombre,         // On sélectionne $nombre articles
                    0                // À partir du premier
                  );
 
    return $this->render('SdzBlogBundle:Blog:menu.html.twig', array(
      'liste_articles' => $liste // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
    ));
  }
}