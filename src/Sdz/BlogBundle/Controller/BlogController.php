<?php
// src/Sdz/BlogBundle/Controller/BlogController.php
 
namespace Sdz\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Sdz\BlogBundle\Entity\Article;
use Sdz\BlogBundle\Entity\Image;
use Sdz\BlogBundle\Entity\Commentaire;
use Sdz\BlogBundle\Entity\Categorie;

class BlogController extends Controller
{
  public function indexAction($page)
  {
    if( $page < 1 )
      throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
	$articles = array(
    array('titre' => 'Mon weekend a Phi Phi Island !',          'id' => 1, 'auteur' => 'winzou',  'contenu' => 'Ce weekend était trop bien. Blabla…',  'date' => new \Datetime()),
    array('titre' => 'Repetition du National Day de Singapour', 'id' => 2, 'auteur' => 'winzou',  'contenu' => 'Bientôt prêt pour le jour J. Blabla…', 'date' => new \Datetime()),
    array('titre' => 'Chiffre d\'affaire en hausse',            'id' => 3, 'auteur' => 'M@teo21', 'contenu' => '+500% sur 1 an, fabuleux. Blabla…',    'date' => new \Datetime())
    );
     
	return $this->render('SdzBlogBundle:Blog:index.html.twig', array(
    'articles' => $articles
	));
  }

  public function voirAction($id)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()
               ->getManager();
    // On récupère l'entité correspondant à l'id $id
    $article = $em->getRepository('SdzBlogBundle:Article')
                  ->find($id);
    if($article === null)
      throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
    // On récupère les articleCompetence pour l'article $article
    $liste_articleCompetence = $em->getRepository('SdzBlogBundle:ArticleCompetence')
                            ->findByArticle($article->getId());
    // Puis modifiez la ligne du render comme ceci, pour prendre en compte les articleCompetence :
    return $this->render('SdzBlogBundle:Blog:voir.html.twig', array(
      'article'          => $article,
      'liste_articleCompetence'  => $liste_articleCompetence,
      // … et évidemment les autres variables que vous pouvez avoir
    ));
  }

  public function ajouterAction()
  {
    // On récupére l'EntityManager
    $em = $this->getDoctrine()
               ->getManager();
    // Création de l'entité Article
    $article = new Article();
    $article->setTitre('777777 je crois');
    $article->setContenu("C'était vraiment super et on s'est bien amusé.");
    $article->setAuteur('winzou');
    // Dans ce cas, on doit créer effectivement l'article en bdd pour lui assigner un id
    // On doit faire ça pour pouvoir enregistrer les ArticleCompetence par la suite
    $em->persist($article);
    $em->flush(); // Maintenant, $article a un id définit
    // Les compétences existent déjà, on les récupère depuis la bdd
    $liste_competences = $em->getRepository('SdzBlogBundle:Competence')
                            ->findAll(); // Pour l'exemple, notre Article contient toutes les Competences
    // Pour chaque compétence
    foreach($liste_competences as $i => $competence)
    {
      // On crée une nouvelle "relation entre 1 article et 1 compétence"
      $articleCompetence[$i] = new ArticleCompetence;
      // On la lie à l'article, qui est ici toujours le même
      $articleCompetence[$i]->setArticle($article);
      // On la lie à la compétence, qui change ici dans la boucle foreach
      $articleCompetence[$i]->setCompetence($competence);
      // Arbitrairement, on dit que chaque compétence est requis au niveau 'Expert'
      $articleCompetence[$i]->setNiveau('Expert');
      // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
      $em->persist($articleCompetence[$i]);
    }
    // On déclenche l'enregistrement
    $em->flush();
    // Reste de la méthode qu'on avait déjà écrit
    if( $this->get('request')->getMethod() == 'POST' )
    {
      $this->get('session')->setFlash('notice', 'Article bien enregistré');
      return $this->redirect( $this->generateUrl('sdzblog_voir', array('id' => $article->getId())) );
    }
    return $this->render('SdzBlogBundle:Blog:ajouter.html.twig');
  }

  public function modifierAction($id)
  {
    // On récupère l'EntityManager
    $em = $this->getDoctrine()
	->getManager();
	// On récupère l'entité correspondant à l'id $id
	$article = $em->getRepository('SdzBlogBundle:Article')
	->find($id);

	if($article === null)
	{
		throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
	}

	// On récupère toutes les catégories :
	$liste_categories = $em->getRepository('SdzBlogBundle:Categorie')
	->findAll();

	// On boucle sur les catégories pour les lier à l'article
	foreach($liste_categories as $categorie)
	{
		$article->addCategorie($categorie);
	}

	// Etape 2 : On déclenche l'enregistrement
	$em->flush();

	return new Response('OK');
  }
  
  // Suppression des catégories d'un article :
  public function supprimerAction($id)
  {
    $em = $this->getDoctrine()
               ->getManager();
    $article = $em->getRepository('SdzBlogBundle:Article')
                  ->find($id);
    if($article === null)
    {
      throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
    }
    $liste_categories = $em->getRepository('SdzBlogBundle:Categorie')
                           ->findAll();
    foreach($liste_categories as $categorie)
    {
      $article->removeCategorie($categorie);
    }
    return new Response('OK');
  }
  
   public function menuAction($nombre)
  {
     $liste = array(
      array('id' => 2, 'titre' => 'Mon dernier weekend !'),
      array('id' => 5, 'titre' => 'Sortie de Symfony2.1'),
      array('id' => 9, 'titre' => 'Petit test')
    );
    return $this->render('SdzBlogBundle:Blog:menu.html.twig', array(
      'liste_articles' => $liste // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
    ));
  }
  
  public function modifierImageAction($id_article)
  {
	$em = $this->getDoctrine()->getManager();
	$article = $em->getRepository('SdzBlogBundle:Article')->find($id_article);
	$article->getImage()->setUrl('test.png');
	$em->flush();
	return new Response('OK');
  }
  
  public function listeAction()
  {
    $liste_articles = $this->getDoctrine()
                           ->getEntityManager()
                           ->getRepository('SdzBlogBundle:Article')
                           ->getArticleAvecCommentaires();
    foreach($liste_articles as $article)
    {
      $article->getCommentaires(); // Ne déclenche pas de requête : les commentaires sont déjà chargés ! Vous pourriez faire une boucle dessus pour les afficher tous.
    }
  }
  
  public function testAction()
  {
    $article = new Article();
    $article->setTitre("L'histoire d'un bon weekend !");
    $em = $this->getDoctrine()->getManager();
    $em->persist($article);
    $em->flush(); // C'est à ce moment qu'est généré le slug
    return new Response('Slug généré : '.$article->getSlug()); // Affiche « Slug généré : l-histoire-d-un-bon-weekend»
  }
}