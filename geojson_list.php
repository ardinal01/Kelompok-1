<?php
$dir = __DIR__;
$files = array_diff(scandir($dir), ['.', '..', 'geojson_list.php']);

$result = [];

foreach ($files as $f) {
    if (pathinfo($f, PATHINFO_EXTENSION) === "geojson") {
        $result[] = "geojson.jatim/" . $f;
    }
}

header('Content-Type: application/json');
echo json_encode($result);
