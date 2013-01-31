<?php

/* SdzBlogBundle:Blog:formulaire.html.twig */
class __TwigTemplate_022434ef12460acec3918b89efebea8a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo " 
<div class=\"well\">
  <form method=\"post\" ";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'enctype');
        echo ">
    ";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getContext($context, "form"), 'widget');
        echo "
 
    ";
        // line 8
        echo "    <a href=\"#\" id=\"add_category\" class=\"btn\">Ajouter une catégorie</a><br /><br />
 
    <input type=\"submit\" class=\"btn btn-primary\" />
  </form>
</div>
 
<!-- On charge la librairie jQuery. Ici, je la prends depuis le site jquery.com, mais si vous l'avez en local, changez simplement l'adresse. -->
<script src=\"http://code.jquery.com/jquery-1.8.2.min.js\"></script>
 
<script type=\"text/javascript\">
\$(document).ready(function() {
  // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse
  var \$container = \$('#sdz_blogbundle_articletype_categories');
 
  // On définit une fonction qui va ajouter un champ
  function add_category() {
    // On définit le numéro du champ (en comptant le nombre de champs déjà ajoutés)
    index = \$container.children().length;
 
    // On ajoute à la fin de la balise <div> le contenu de l'attribut « data-prototype »
    // Après avoir remplacé la variable __name__ qu'il contient par le numéro du champ
    \$container.append(\$(\$container.attr('data-prototype').replace(/__name__/g, index)));
 
    // On ajoute également un bouton pour pouvoir supprimer la catégorie
    \$container.append(\$('<a href=\"#\" id=\"delete_category_' + index + '\" class=\"btn btn-danger\">Supprimer</a><br /><br />'));
 
    // On supprime le champ à chaque clic sur le lien de suppression
    \$('#delete_category_' + index).click(function() {
      \$(this).prev().remove();  // \$(this).prev() est le template ajouté
      \$(this).remove();         // \$(this) est le lien de suppression
      return false;
    });
  }
 
  // On ajoute un premier champ directement s'il n'en existe pas déjà un (cas d'un nouvel article par exemple)
  if(\$container.children().length == 0) {
    add_category();
  }
 
  // On ajoute un nouveau champ à chaque clic sur le lien d'ajout
  \$('#add_category').click(function() {
    add_category();
    return false;
  });
});
</script>";
    }

    public function getTemplateName()
    {
        return "SdzBlogBundle:Blog:formulaire.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 8,  27 => 5,  23 => 4,  19 => 2,);
    }
}
