<?php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
  public function myFindAll()
  {
    $queryBuilder = $this->createQueryBuilder('a');
    // M�thode �quivalente, mais plus longue :
    $queryBuilder = $this->_em->createQueryBuilder()
      ->select('a')
      ->from($this->_entityName, 'a'); // Dans un repository, $this->_entityName est le namespace de l'entit� g�r�e
    // Ici, il vaut donc Sdz\BlogBundle\Entity\Article
    // On a fini de construire notre requ�te
    // On r�cup�re la Query � partir du QueryBuilder
    $query = $queryBuilder->getQuery();
    // On r�cup�re les r�sultats � partir de la Query
    $resultats = $query->getResult();
    // On retourne ces r�sultats
    return $resultats;
  }
  
  public function myFindOne($id)
  {
    // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
    $qb = $this->_em->createQueryBuilder();
    $qb->select('a')
	  ->from('SdzBlogBundle:Article', 'a')
      ->where('a.id = :id')
      ->setParameter('id', $id);
    return $qb->getQuery()
              ->getResult();
  }
  
  public function findByAuteurAndDate($auteur, $annee)
  {
    // On utilise le QueryBuilder cr�� par le repository directement pour gagner du temps
    // Plus besoin de faire le select() ni le from() par la suite donc
    $qb = $this->createQueryBuilder('a');
    $qb->where('a.auteur = :auteur')
      ->setParameter('auteur', $auteur)
      ->andWhere('a.date < :annee')
      ->setParameter('annee', $annee)
     ->orderBy('a.date', 'DESC');
    return $qb->getQuery()
              ->getResult();
  }
  
  public function whereCurrentYear(\Doctrine\ORM\QueryBuilder $qb)
  {
    $qb->andWhere('a.date BETWEEN :debut AND :fin')
    ->setParameter('debut', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette ann�e
    ->setParameter('fin',   new \Datetime(date('Y').'-12-31')); // Et le 31 d�cembre de cette ann�e
    return $qb;
  }
  
  public function myFind()
  {
    $qb = $this->createQueryBuilder('a');
    // On peut rajouter ce qu'on veut avant
    $qb->where('a.auteur = :auteur')
      ->setParameter('auteur', 'winzou');
    // On applique notre condition
    $qb = $this->whereCurrentYear($qb);
    // On peut rajouter ce qu'on veut apr�s
    $qb->orderBy('a.date', 'DESC');
    return $qb->getQuery()
              ->getResult();
  }
  
  public function myFindAllDQL()
  {
    $query = $this->_em->createQuery('SELECT a FROM SdzBlogBundle:Article a');
    $resultats = $query->getResult();
    return $resultats;
  }
  
  public function getArticleAvecCommentaires()
  {
    $qb = $this->createQueryBuilder('a')
               ->leftJoin('a.commentaires', 'c')
               ->addSelect('c');
    return $qb->getQuery()
              ->getResult();
  }
  
  public function getAvecCategories(array $nom_categories)
  {
    $qb = $this->createQueryBuilder('a');
    // On fait une jointure avec l'entit� Categorie, avec pour alias � c �
    $qb ->join('a.categories', 'c')
        ->where($qb->expr()->in('c.nom', $nom_categories)); // Puis on filtre sur le nom des cat�gories � l'aide d'un IN
    // Enfin, on retourne le r�sultat
    return $qb->getQuery()
              ->getResult();
  }
}
