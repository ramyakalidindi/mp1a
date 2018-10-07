<?php

main::start("file.csv");

class main {

    static public function start($filename)
    {

        $records = csv::getRecords($filename);
        $tableHtml = html::generateTable($records);

        print_r($tableHtml);
    }

}
class html {
    public static function generateTable($records) {
        $count = 0;
        $tableHtml = "<table class='table table-striped'>";
        foreach($records as $record) {
            if($count ==0) {
                $tableHtml .= "<thead><tr> ";
                foreach ($record->returnArray() as $value) {
                    $tableHtml .= "<th scope='col'>" . $value . "</th>";
                }
                $tableHtml .= "</tr></thead><tbody>";
            } else {
                $tableHtml .= "<tr>";
                foreach ($record->returnArray() as $value) {
                    $tableHtml .= "<td>" . $value . "</td>";
                }
                $tableHtml .= "</tr>";
            }
            $count++;
        }
        $tableHtml .= "</tbody></table>";
        return $tableHtml;
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

    public function returnArray() {
        return $this->{"valuesArray"};

    }
}

class recordFactory {
    public static function create(Array $array = null) {
        $record = new record($array);
        return $record;
    }
}