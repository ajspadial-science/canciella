<?php

namespace spec\Canciella\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProxySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Canciella\Controllers\Proxy');
    }

    function it_process_double_slash_url()
    {
         $href = "//www.uniovi.es";
         $base = "http://canciella.net/go/";
         $url = "http://sciencedirect.com/science/journal/00032670";
         $this->appendProxy($href, $base, $url)->shouldReturn("{$base}http:$href");
    }

    function it_process_absolute_urls()
    {
        $href = 'http://www.uniovi.es';
        $base = 'http:/canciella.net/go/';
        $url = 'http://sciencedirect.com/science/journal/00032670';
        $this->appendProxy($href, $base, $url)->shouldReturn("{$base}$href");
    }

    function it_process_absolute_address_in_same_domain()
    {
        $href = '/search';
        $base = 'http://canciella.net/go/';
        $url = 'http://sciencedirect.com/science/journal/00032670';
        $this->appendProxy($href, $base, $url)->shouldReturn("{$base}http://sciencedirect.com$href");
    }

    function it_process_relative_address_in_same_domain()
    {
        $href = 'search';
        $base = 'http://canciella.net/go/';
        $url = 'http://sciencedirect.com/science/journal/00032670';
        $this->appendProxy($href, $base, $url)->shouldReturn("{$base}http://sciencedirect.com/science/journal/$href");
    }
}
