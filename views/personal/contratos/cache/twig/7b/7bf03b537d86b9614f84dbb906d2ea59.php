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
class __TwigTemplate_0dab87184a816571986b8ea36a690f55 extends Template
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
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Contrato de Trabajo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Reducir el tamaño de la fuente */
            line-height: 1.4; /* Reducir el espacio entre líneas */
            color: #000;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-top: 50px;
        }
        .page-break {
            page-break-after: always;
        }
        .bold-variable {
            font-weight: bold;
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class=\"container\">
        
        <p style=\"text-align: justify;\">CONTRATO INDIVIDUAL DE TRABAJO <b>POR OBRA DETERMINADA <b/>  QUE CELEBRAN, POR UNA PARTE \"IMPULSO BTL S.A. DE C.V.\", 
        REPRESENTADA EN ESTE ACTO POR DAVID GERARDO ROMERO BALA EN SU CARACTER DE REPRESENTANTE LEGAL Y A QUIEN EN LO SUCESIVO 
        SE LE DESIGNARA COMO \"LA EMPRESA\", Y POR LA OTRA, POR SU PROPIO DERECHO EL (LA) C. <span class=\"bold-variable\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["nombre"] ?? null), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app"] ?? null), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["apm"] ?? null), "html", null, true);
        yield "</span> Y A QUIEN 
        EN LO SUCESIVO SE LE DESIGNARA COMO \"EL (LA) TRABAJADOR (A)\" AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS.</p>

        <div style=\"text-align: center;\"><h2>DECLARACIONES</h2></div>

        <h3>I.- DE LA EMPRESA:</h3>

        <p>1.- Señala que se trata de una sociedad anónima de capital variable constituida conforme a las leyes mexicanas y tener como principal objeto
        social todo lo relacionado con la prestación de servicios administrativos y técnicos de apoyo empresarial, reclutamiento, selección y
        contratación de personal, en todos sus niveles y categorías, tener su domicilio en Av. Cuauhtémoc número 1338 piso 2 int 201, Col. Santa Cruz
        Atoyac C.P 03310, Demarcación Territorial Benito Juárez en la Ciudad de México.</p>

        <p>2.- Manifiesta que consistente en el trabajo de <span class=\"bold-variable\">PUESTO</span> con una duración hasta el <span class=\"bold-variable\">FECHA DE EGRESO</span>. los cuales se
        consideraran laborables a partir <span class=\"bold-variable\">FECHA DE INGRESO</span>.</p>

        <p>3.- Refiere que con motivo de la necesidad derivada de la obra determinada especificada en el inciso que antecede, la que no puede llevarla
        a cabo con el personal de planta que tiene actualmente bajo su servicio \"LA EMPRESA\", le surge la necesidad eventual y transitoria de
        contratar los servicios temporales de \" EL (LA) TRABAJADOR (A) , únicamente por el tiempo que subsista la materia objeto de éste contrato
        y hasta la terminación de la misma, en que deje de existir la necesidad temporal de contar con los servicios de personal capacitado para el
        desarrollo y ejecución de la obra determinada referida.</p>


        <p>4.- Por último, se manifiesta que mientras subsista la materia del trabajo señalado en el inciso 2 que antecede, existirá la necesidad de \"LA
        EMPRESA\" de recibir los servicios de \"EL (LA) TRABAJADOR (A)\" y serán necesarios hasta que deje de existir la materia objeto de este contrato.</p>

<h3>II.- EL (LA) TRABAJADOR (A) MANIFIESTA:</h3>

        <p>1.- A) Llamarse como ha quedado escrito en este contrato.</p>

        <p>B) De nacionalidad mexicana, como lo acredita con acta de nacimiento respectiva.</p>

        <p>C) Tener <span class=\"bold-variable\">Edad</span> años cumplidos de edad.</p>

        <p>D) Estado Civil: _____________________________</p>

        <p>E) CURP: <span class=\"bold-variable\">";
        // line 75
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["curp"] ?? null), "html", null, true);
        yield "</span> RFC: <span class=\"bold-variable\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["rfc"] ?? null), "html", null, true);
        yield "</span></p>

        <p>F) De sexo: <span class=\"bold-variable\">";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["sexo"] ?? null), "html", null, true);
        yield "</span></p>

        <p>G) Tener su domicilio en la calle de: CERRADA PORFIDO 500 INT 50
        Col. LOS ENCINOS C.P. 76243 Alcaldía EL MARQUEZ</p>

        <p>2.- Que ha recibido una amplia y completa explicación por parte de los representantes de \"LA EMPRESA \" de la naturaleza y servicios que
        prestará en forma eventual y transitoria en la ejecución de la obra determinada objeto de éste contrato, manifestando bajo protesta de decir
        verdad, que cuenta con la capacidad, aptitudes, experiencia y conocimientos necesarios para llevar a cabo la ejecución de la obra
        determinada antes referida, estando totalmente conforme en prestar sus servicios temporales a \" LA EMPRESA \" y únicamente por el tiempo
        que dure ésta.</p>

        <p>III.- Como consecuencia de lo anterior, las partes están totalmente de acuerdo en dar por terminada la relación laboral derivada de este
        contrato, sin ninguna responsabilidad para ninguna de ellas, conforme lo determina la Fracción III del Artículo 53 de la Ley Federal del Trabajo.</p>

        <p>IV.- Las partes aceptan y están de acuerdo en celebrar el presente contrato de trabajo por obra determinada de conformidad con lo dispuesto
        en los Artículos 36, 37 y demás relativos del ordenamiento legal invocado, bajo las siguientes:</p>

        <div style=\"text-align: center;\"><h2>C L A U S U L A S.</h2></div>

<p><b>PRIMERA. -</b> \"LA EMPRESA\" contrata los servicios de \"EL (LA) TRABAJADOR (A)\", quien se obliga a prestarlos personalmente como EJECUTIVO
DE CUENTA, bajo la dirección y dependencia de la primera, conviniendo en seguir y cumplir con las indicaciones e instrucciones que reciba
de sus superiores, así como aquellas actividades anexas o conexas con la principal.</p>

<p>Queda convenido que \"EL (LA) TRABAJADOR (A)\" tendrá siempre y en todo momento la obligación de mostrar disposición y buenos modales
en el desempeño de sus labores, mostrando espíritu de colaboración respeto para todos sus compañeros de labores de trabajo y sus
superiores.</p>

<p><b>SEGUNDA. -</b> La duración de este contrato será por tiempo determinado y tendrá vigencia exclusivamente por el tiempo en que subsista la
materia objeto del mismo, en virtud de que la ejecución de la obra señalada en el inciso dos de las declaraciones que anteceden, origina a \"
        LA EMPRESA \" la necesidad eventual y transitoria de contratar los servicios de \"EL (LA) TRABAJADOR (A)\", que se estima se llevará a cabo
        hasta el 19 de diciembre de 2024.</p>

<p><b>TERCERA.-</b> Las partes convienen en que si dentro de los primeros treinta días de servicios \"LA EMPRESA\" se percata que \"EL (LA) TRABAJADOR
        (A)\", altero o falseo la información o documentación presentada como referencias, o bien, no tiene la capacidad, experiencia, aptitudes,
        habilidad o conocimientos que manifiesta tener para el desempeño del puesto para el cual fue contratado, se dará por terminado éste
        contrato sin ninguna responsabilidad para \"LA EMPRESA\", bastando dar aviso por escrito a \"EL (LA) TRABAJADOR \" personalmente y de
        negarse a recibirlo, se le notificará en el último domicilio que tuviera señalado, bastando señalar la decisión de dar por terminado el contrato,
        para que cese sus efectos legales sin responsabilidad para las partes contratantes.</p>

<p><b>CUARTA. -</b> Queda convenido entre las partes que el salario que percibirá \"EL (LA) TRABAJADOR \"A\" por sus servicios personales será la
        cantidad de \$16,000.00 (DIECISÉIS MIL PESOS 00\\100 M. N.) brutos mensuales, cuyo pago se efectuaran los días quince y último de cada
        mes y en el cual queda incluido además el pago del séptimo día, descansos obligatorios y la prima dominical, cuando esporádicamente tenga
        que trabajar en día domingo.</p>
        <!-- Continuar con el resto de las cláusulas -->

        <div class=\"page-break\"></div>

<p><b>QUINTA.-</b> \" EL (LA) TRABAJADOR (A)\" se obliga a firmar los recibos o comprobantes de pago que acostumbra llevar \"LA EMPRESA\", que
        amparan el pago de los salarios o prestaciones devengadas por la prestación de sus servicios en forma personal, quedando claramente
        establecido que el otorgamiento de los mismos implica un finiquito total hasta la fecha que ampara el recibo o comprobante respectivo, por
        lo que sí \"EL (LA) TRABAJADOR (A)\" tuviera que hacer alguna aclaración sobre sus percepciones, deberá hacerlo precisamente en el momento
        de recibir su pago, ya que de no hacerlo, se entenderá que lo recibe a su entera conformidad y no se admitirá ninguna reclamación futura
        una vez firmado el recibo o el comprobante respectivo.</p>

        <p>Queda igualmente convenido que \"LA EMPRESA\" podrá aplicar en los recibos o comprobantes de pago de \"EL (LA) TRABAJADOR (A)\", los
        descuentos, cuotas sindicales, reposición , abonos, etc., como pueden ser las cuotas del Instituto Mexicano del Seguro Social, Impuestos
        Sobre Productos de Trabajo, préstamos personales, reposición de material o instrumentos de trabajo extraviados o deteriorados por
        negligencia o impericia de \"EL (LA) TRABAJADOR (A)\", los permitidos o autorizados por la Ley y los convenidos por las partes.</p>

<p><b>SEXTA. -</b> Las partes convienen en que \"EL (LA) TRABAJADOR (A)\" prestará sus servicios personales dentro de una jornada discontinua de
        labores por 6 (seis) días a la semana, disfrutando de un descanso los días domingo de cada semana y cuyo pago se encuentra incluido en el
salario estipulado en la cláusula cuarta que antecede.</p>

<p> Igualmente convienen las partes que de acuerdo a las necesidades de \"LA EMPRESA\" y cuando requiera que \" EL (LA) TRABAJADOR (A)\"
            prolongue su jornada ordinaria de trabajo, éste se obliga desde éste momento a trabajar el tiempo extraordinario que fuera necesario, dentro
            de lo permitido por la propia Ley, pero siempre deberá ser autorizado previamente y por escrito por \"LA EMPRESA\", indicando las causas o
            motivos que originen la necesidad de laborar tiempo extra, requisito sin el cual, no habrá ninguna obligación o responsabilidad de \"LA
            EMPRESA\" de pagar tiempo extra. </p>
            
<p><b>SEPTIMA. -</b> \"EL (LA) TRABAJADOR (A)\" disfrutará de un período proporcional de vacaciones de conformidad a lo establecido en el artículo 76 y 78 de
            la Ley Federal del Trabajo.</p>
            
<p><b>OCTAVA.-</b> Los períodos vacacionales deberán concederse dentro de los seis meses siguientes en que cumpla años de servicios \"EL (LA)
            TRABAJADOR (A)\", para lo cual, \"LA EMPRESA \" elaborará el calendario de vacaciones respectivo que se le dará a conocer con toda
            oportunidad, teniendo ésta última la facultad para modificar el período vacacional, tantas veces como fuera necesario en razón a las
            necesidades del servicio, debiendo notificar \" AL TRABAJADOR (A)\" del nuevo período de vacaciones, cuando menos con tres días de
            anticipación de la fecha en que deba iniciar éste, estando obligado éste último a acatar el nuevo período vacacional.</p>

<p><b>NOVENA. -</b> \"EL (LA) TRABAJADOR (A)\" tendrá derecho a percibir un aguinaldo proporcional de acuerdo a la prestación de servicios, y en caso de
continuar su prestación de servicios, se pagará antes del 20 de diciembre equivalente al importe de 15 días de salario de acuerdo con lo dispuesto
en el artículo 87 de la Ley.</p>

<p><b>DECIMA. -</b> \"EL (LA) TRABAJADOR (A)\" se obliga a someterse a los exámenes médicos que periódicamente ordene \"LA EMPRESA\" en los
términos de la fracción X del artículo 134 de la Ley Federal del Trabajo, en el entendido que el médico que practique dichos exámenes, será
designado y retribuido por ésta última.</p>

<p><b>DECIMA PRIMERA.-</b> \"EL (LA) TRABAJADOR (A)\" está obligado a tomar los cursos de capacitación y adiestramiento que \"LA EMPRESA\"
determine, con el objeto de elevar su nivel de vida y productividad, en cumplimiento a lo previsto en el Título Cuarto, Capítulo III Bis de la
Ley Federal del Trabajo, para lo cual se compromete a asistir puntualmente a los mismo aún fuera de su jornada ordinaria de labores,
poniendo todo su empeño y esfuerzo para aprovecharlos al máximo, así como a trasmitir e impartir a su vez,
cuantas veces sea necesario, a la o las personas que designe \"LA EMPRESA\", los conocimientos e información que haya adquirido en los
cursos respectivos, sin retribución de ninguna especie, y aun cuando lo tenga que hacer fuera de su jornada ordinaria de labores, que, en
ningún caso, se podrán considerar como tiempo extraordinario de labores.</p>

<p><b>DECIMA SEGUNDA.-</b> \"EL (LA) TRABAJADOR (A)\" tendrá la obligación de prestar sus servicios en los días y dentro de la jornada de trabajo
señalados en éste contrato, con las modalidades que se contemplan en el Reglamento Interior de Trabajo, no obstante lo cual, faculta desde
ahora a \"LA EMPRESA\" para poder modificar o variar, tanto los días de descanso semanal como la jornada de labores, de acuerdo a las
necesidades del trabajo, ya sea en forma temporal o definitiva, con la única obligación de comunicarle \"AL TRABAJADOR (A)\", en forma
verbal, con una anticipación de cuando menos de tres días hábiles de la fecha en que deberá operar dicho cambio.
Queda entendido que el ejercicio de la facultad otorgada expresamente por \"EL (LA) TRABAJADOR (A)\" en favor de \"LA EMPRESA\" señalada
expresamente en esta cláusula, no implica en modo alguno modificación unilateral a las condiciones generales de trabajo pactadas en este
contrato y, por lo tanto, no constituye causa o motivo de rescisión de la relación laboral existente entre las partes.</p>

<p><b>DECIMA TERCERA. -</b> Queda convenido entre las partes que cuando \"EL (LA) TRABAJADOR (A)\" tenga la necesidad imperiosa de faltar a sus
labores, deberá solicitar permiso a \"LA EMPRESA\" por escrito con toda anticipación, la que a su vez podrá negar o conceder el permiso, en
cuyo caso deberá ser siempre por escrito, requisito sin el cual, se considerará la inasistencia como falta injustificada. Cuando la causa de la
inasistencia fuera imprevista, deberá dar aviso por teléfono a su superior jerárquico, o en su defecto, a su jefe directo o inmediato, dentro
de los treinta minutos siguientes de la hora en que debió iniciar su jornada de trabajo.</p>

<p>El aviso a que se refiere el párrafo anterior, no justifica en modo alguno la inasistencia al trabajo, por lo que, en todo caso, \" EL (LA)
TRABAJADOR (A)\" al regresar a su trabajo e iniciar sus labores, inmediatamente deberá comprobar su inasistencia con el o los comprobantes
respectivos, que, en caso de enfermedad, únicamente podrá ser con el certificado de incapacidad médica expedido por el Instituto Mexicano
del Seguro Social, entregando a \"LA EMPRESA\" la copia respectiva.</p>

<p>Si \" EL (LA) TRABAJADOR (A)\" faltó a sus labores por cualquier otra causa imprevista y que le haya impedido solicitar permiso previo y por
escrito a \"LA EMPRESA\", al reanudar sus labores deberá presentar y entregar a la persona adecuada, o en su caso, a su jefe inmediato, el o
los comprobantes que a juicio de \"LA EMPRESA\" considere necesarios a fin de justificar su inasistencia, ya que, en caso contrario, se
considerará como falta injustificada para todos los efectos legales a que hubiera lugar.</p>

<p><b>DÉCIMO CUARTA.-</b> Las partes convienen expresamente que dada la naturaleza del objeto social de \"LA EMPRESA\" y de los servicios
temporales para los cuales es contratado \"EL (LA) TRABAJADOR (A)\" y por los cuales tiene acceso a información considerada como
confidencial, por lo que se compromete éste último a guardar y no revelar o divulgar ningún dato o información de técnicas de operación,
comercialización, ventas o cualesquier otras que utilice o se llegara a implantar en lo futuro, así como cualquier hecho que tuviera
conocimiento con motivo del desempeño de su trabajo, quedando entendido que la falta de ésta prohibición será motivo suficiente para dar
por terminado éste contrato inmediatamente y sin responsabilidad para la \"LA EMPRESA\", sin perjuicio de los posibles daños y perjuicios que
pudieran ocasionarse en su contra y de los cuales será responsabilidad exclusiva de \"EL (LA) TRABAJADOR (A)\".</p>

        <div class=\"page-break\"></div>



        <!-- Sección de firmas -->
        <div class=\"signature\">
            <div class=\"signature-line\"></div>
            <p>\"LA EMPRESA\"<br><span class=\"bold-variable\">";
        // line 211
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["representante_legal"] ?? null), "html", null, true);
        yield "</span></p>
        </div>

        <div class=\"signature\">
            <div class=\"signature-line\"></div>
            <p>\"EL (LA) TRABAJADOR (A)\"<br><span class=\"bold-variable\">";
        // line 216
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["nombre"] ?? null), "html", null, true);
        yield "</span></p>
        </div>
    </div>
    <!-- Nueva página con la imagen -->
    <div class=\"page-break\"></div>
    <div style=\"text-align: center; margin-top: 50px;\">
        <img src=\"test.jpeg\" style=\"max-width: 80%; height: auto;\" alt=\"Logo Mctree\">
    </div>
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
        return array (  277 => 216,  269 => 211,  132 => 77,  125 => 75,  83 => 40,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "contrato.html.twig", "/home/runner/intranetgmt/views/personal/contratos/templates/contrato.html.twig");
    }
}
