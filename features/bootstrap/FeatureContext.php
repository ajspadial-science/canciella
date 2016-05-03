<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When navego a la revista :arg1 a través del proxy
     */
    public function navegoALaRevistaATravesDelProxy($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then todos los enlaces devueltos acceden a traves del proxy
     */
    public function todosLosEnlacesDevueltosAccedenATravesDelProxy()
    {
        throw new PendingException();
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
