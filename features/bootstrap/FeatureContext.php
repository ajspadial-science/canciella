<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Canciella\Journal;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    private $base_url;
    private $output;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        include __DIR__ . '/../../src/config.php';
        $this->base_url = $base_domain;
    }

    /**
     * @When navego a la revista :arg1 a través del proxy
     */
    public function navegoALaRevistaATravesDelProxy($arg1)
    {
        $j = Journal::getJournalByName($arg1);
        $uri = $j->website;
        
        $p = new \Canciella\Controllers\Proxy();
        $this->output = $p->processUri($uri, $this->base_url)[0]; 
    }

    /**
     * @Then todos los enlaces devueltos acceden a traves del proxy
     */
    public function todosLosEnlacesDevueltosAccedenATravesDelProxy()
    {
       $proxy = new \Canciella\Controllers\Proxy();
       $proxy->initDOM($this->output);
       $proxy->linkableElements_walk(
           function($element, $attribute_name, $attribute) {
               if (!empty($attribute) && strpos($attribute, $this->base_url) !== 0) {
                   throw new Exception("Proxy not used in element {$element->C14N()}");
               }
           }
       );
    }

    /**
     * @Given que la revista :arg1 tiene un artículo :arg2
     */
    public function queLaRevistaTieneUnArticulo($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When pongo :arg1 en el cajón Buscar
     */
    public function pongoEnElCajonBuscar($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When hago clic en primer enlace del resultado
     */
    public function hagoClicEnPrimerEnlaceDelResultado()
    {
        throw new PendingException();
    }

    /**
     * @Then obtengo un artículo en formato pdf
     */
    public function obtengoUnArticuloEnFormatoPdf()
    {
        throw new PendingException();
    }

    /**
     * @When navego a la revista '' a través del proxy
     */
    public function navegoALaRevistaATravesDelProxy2()
    {
        throw new PendingException();
    }

    /**
     * @Given que la revista '' tiene un artículo :arg1
     */
    public function queLaRevistaTieneUnArticulo2($arg1)
    {
        throw new PendingException();
    }
}
