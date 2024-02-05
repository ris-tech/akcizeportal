<?php

$docPath = __DIR__.'/storage'.DIRECTORY_SEPARATOR.'16497fa0'.DIRECTORY_SEPARATOR.'12'.DIRECTORY_SEPARATOR;
echo $docPath.'<br>';
$tmpDocPath = $docPath."tmp".DIRECTORY_SEPARATOR;
echo $tmpDocPath.'<br>';
$tmpDocPathws = $docPath."tmp";
echo $tmpDocPathws.'<br>';
$newZip = $docPath."sken_ulazne_fakture.tar.gz";
echo $newZip.'<br>';
if (is_file($newZip)) {
echo 'ist vorhanden<br>';
}
//echo 'tar -xvzf '.$newZip.' -C '.$tmpDocPath;

$zip = new ZipArchive;
$res = $zip->open('/www/htdocs/w01e31de/portal.akcize.rs/storage/app/public/16497fa0/12/sken_ulazne_fakture.zip');
if ($res === TRUE) {
    $zip->extractTo($tmpDocPath);
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

?>