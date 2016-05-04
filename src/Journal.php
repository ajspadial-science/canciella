<?php

namespace Canciella;

class Journal
{
    private static $loaded;
    private static $journals = array();

    private $name;
    public $website;
    public $host;

    public function __construct($name, $website)
    {
        $this->name = $name;
        $this->website = $website;

        $this->host = parse_url($this->website, PHP_URL_HOST);
    }

    public function __toString()
    {
        return "$this->name[$this->website]";
    }

    public function createTests($folder)
    {
        $m = new Mustache_Engine();
        $template = file_get_contents('templates/featurePublisher.template');
        $content = $m->render(
            $template,
            array(
                'name_journal' => $this->name,
                'host' => $this->host,
            )
        );
        file_put_contents("$folder/{$this->getSlug()}.feature", $content);
    }

    public function getSlug()
    {
      return strtolower(metaphone($this->name));
    }

    public static function showList()
    {
        self::initStatic();
        $showable = [];
        foreach (self::$journals as $j) {
            if (self::searchInArrayByHost($showable, $j->host) === false) {
                $showable[] = $j;
            }
        }
        return implode("\n", $showable);
    }

    private static function initStatic()
    {
        self::loadFile('fixtures/revistas.csv');
    }

    private static function loadFile($filename)
    {
        if (!self::$loaded) {
            $rows = file($filename);
            foreach($rows as $r) {
                $fields = array_map('trim', explode(";", $r));
                self::$journals[] = new Journal($fields[0], $fields[3]);
            }
            self::$loaded = true;
        }
    }

    public static function getJournalByName($name)
    {
        self::initStatic();
        return self::searchInArrayByProperty(self::$journals, 'name', $name);
    }

    public static function getJournalByHost($host)
    {
         self::initStatic();
         return self::searchInArrayByHost(self::$journals, $host);
    }

    private static function searchInArrayByHost($array, $host)
    {
        return self::searchInArrayByProperty($array, 'host', $host);
    }

    private static function searchInArrayByProperty($array, $property, $value)
    {
        foreach($array as $e) {
            if ($e->$property === $value) {
                return $e;
            }
        }
        return false;
    }
}
