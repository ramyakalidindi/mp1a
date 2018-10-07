<?php

main::start("file.csv");

class main {

    static public function start($filename)
    {

        $html = "<html><head><link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" integrity=\"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO\" crossorigin=\"anonymous\">

<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/stylesheets/main.css\" /></head><body>";

        $records = csv::getRecords($filename);
        $tableHtml = html::generateTable($records);

        $html .= $tableHtml . "</body></html>";
        print_r($html);
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