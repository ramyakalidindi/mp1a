<?php

main::start("file.csv");

class main {

    static public function start($filename)
    {

        $records = csv::getRecords($filename);

        print_r($records);
    }

}

class csv{

    static public function getRecords($filename) {
        $file = fopen($filename,"r");

        while(! feof($file))
        {
            $record = fgetcsv($file);

            $records[] = recordFactory::create($record);
        }

        fclose($file);
        return $records;

    }

}

class record {

    public function __construct($values)
    {
        $this->createProperty("valuesArray", $values);
    }

    public function createProperty($name, $value) {
        $this->{$name} = $value;
    }
}

class recordFactory {
    public static function create(Array $array = null) {
        $record = new record($array);
        return $record;
    }
}