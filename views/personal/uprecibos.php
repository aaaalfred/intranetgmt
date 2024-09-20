<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        exec('python C:/wamp64/www/nomina/codepy/uprecibos.py', $output, $return_var);
        foreach($output as $line) {
            echo "<pre>$line</pre>";
        }
    }
?>
