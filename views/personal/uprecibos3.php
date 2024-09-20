<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $output = shell_exec('jupyter nbconvert --execute C:/wamp64/www/nomina/codepy/uprecibos.ipynb');
        echo "<pre>$output</pre>";
    }
?>