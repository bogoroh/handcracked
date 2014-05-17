<?php

/* adminHome.html */
class __TwigTemplate_a7b8fab2805ac42c966be9d8751f3d79d179e4c5aade48bf577e49f98506b293 extends Twig_Template
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
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
\t<title>Handcracked's Admin home page</title>
</head>
<body>
\t<h1> Handcracked Admin page  </h1>
\t";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["username"]) ? $context["username"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 9
            echo "\t\t<p>item['username']</p>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "adminHome.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 11,  32 => 9,  28 => 8,  19 => 1,);
    }
}
