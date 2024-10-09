<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* contrato.html.twig */
class __TwigTemplate_337e6fbacc9109b365106ab94659442d extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"es\">
<head>
    <meta charset=\"UTF-8\">
    <title>Contrato Individual de Trabajo por Obra Determinada</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        .page-break {
            page-break-after: always;
        }
        h1, h2, h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 10px;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-line {
            border-top: 1px solid black;
            width: 50%;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <h1>CONTRATO INDIVIDUAL DE TRABAJO POR OBRA DETERMINADA</h1>
    
    <p>QUE CELEBRAN, POR UNA PARTE \"";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["empresa"] ?? null), "html", null, true);
        yield "\", REPRESENTADA EN ESTE ACTO POR ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["representante_legal"] ?? null), "html", null, true);
        yield " EN SU CARACTER DE REPRESENTANTE LEGAL Y A QUIEN EN LO SUCESIVO SE LE DESIGNARA COMO \"LA EMPRESA\", Y POR LA OTRA, POR SU PROPIO DERECHO EL (LA) C. ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["nombre_trabajador"] ?? null), "html", null, true);
        yield " Y A QUIEN EN LO SUCESIVO SE LE DESIGNARA COMO \"EL (LA) TRABAJADOR (A)\" AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS.</p>

    <h2>DECLARACIONES</h2>

    <h3>I.- DE LA EMPRESA:</h3>
    <!-- Contenido de las declaraciones de la empresa -->

    <h3>II.- EL (LA) TRABAJADOR (A) MANIFIESTA:</h3>
    <!-- Contenido de las declaraciones del trabajador -->

    <div class=\"page-break\"></div>

    <h2>CLÁUSULAS</h2>

    <h3>PRIMERA.</h3>
    <!-- Contenido de la cláusula PRIMERA -->

    <h3>SEGUNDA.</h3>
    <!-- Contenido de la cláusula SEGUNDA -->

    <!-- Continuar con el resto de las cláusulas -->

    <div class=\"page-break\"></div>

    <!-- Sección de firmas -->
    <div class=\"signature\">
        <div class=\"signature-line\"></div>
        <p>\"LA EMPRESA\"<br>";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["representante_legal"] ?? null), "html", null, true);
        yield "</p>
    </div>

    <div class=\"signature\">
        <div class=\"signature-line\"></div>
        <p>\"EL (LA) TRABAJADOR (A)\"<br>";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["nombre_trabajador"] ?? null), "html", null, true);
        yield "</p>
    </div>

    <!-- Aquí puede agregar el Aviso de Privacidad y el Convenio de Confidencialidad -->
</body>
</html>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "contrato.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  123 => 70,  115 => 65,  81 => 38,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "contrato.html.twig", "/home/runner/intranetgmt/views/personal/contratos/templates/contrato.html.twig");
    }
}
