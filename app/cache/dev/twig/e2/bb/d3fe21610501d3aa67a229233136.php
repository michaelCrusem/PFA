<?php

/* SdzBlogBundle:Blog:article.html.twig */
class __TwigTemplate_e2bbd3fe21610501d3aa67a229233136 extends Twig_Template
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
";
        // line 4
        $context["accueil"] = ((array_key_exists("accueil", $context)) ? (_twig_default_filter($this->getContext($context, "accueil"), false)) : (false));
        // line 5
        echo " 
<h2>
  ";
        // line 8
        echo "  ";
        if ((!(null === $this->getAttribute($this->getContext($context, "article"), "image")))) {
            // line 9
            echo "    <img src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl($this->getAttribute($this->getAttribute($this->getContext($context, "article"), "image"), "url")), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, "article"), "image"), "alt"), "html", null, true);
            echo "\" />
  ";
        }
        // line 11
        echo " 
  ";
        // line 13
        echo "  ";
        if ($this->getContext($context, "accueil")) {
            // line 14
            echo "    <a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("sdzblog_voir", array("id" => $this->getAttribute($this->getContext($context, "article"), "id"))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "article"), "titre"), "html", null, true);
            echo "</a>
  ";
        } else {
            // line 16
            echo "    ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "article"), "titre"), "html", null, true);
            echo "
  ";
        }
        // line 18
        echo "</h2>
 
<i>Le ";
        // line 20
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getContext($context, "article"), "date"), "d/m/Y"), "html", null, true);
        echo ", par ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "article"), "auteur"), "html", null, true);
        echo ".</i>
 
<div class=\"well\">
  ";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "article"), "contenu"), "html", null, true);
        echo "
</div>
 
";
        // line 27
        if (($this->getAttribute($this->getAttribute($this->getContext($context, "article"), "categories"), "count") > 0)) {
            // line 28
            echo "  <div class=\"well well-small\">
    <p><i>
      Catégories :
      ";
            // line 31
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, "article"), "categories"));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["categorie"]) {
                // line 32
                echo "        ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, "categorie"), "nom"), "html", null, true);
                if ((!$this->getAttribute($this->getContext($context, "loop"), "last"))) {
                    echo ", ";
                }
                // line 33
                echo "      ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['categorie'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 34
            echo "    </i></p>
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "SdzBlogBundle:Blog:article.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 34,  107 => 33,  101 => 32,  84 => 31,  79 => 28,  77 => 27,  63 => 20,  59 => 18,  53 => 16,  45 => 14,  31 => 9,  28 => 8,  24 => 5,  22 => 4,  19 => 2,  120 => 30,  109 => 27,  102 => 26,  97 => 25,  92 => 21,  85 => 19,  71 => 23,  68 => 16,  66 => 15,  48 => 14,  42 => 13,  39 => 11,  32 => 6,  29 => 5,);
    }
}
