<?php
include('src/BarcodeGenerator.php');
include('src/BarcodeGeneratorPNG.php');
include('src/BarcodeGeneratorSVG.php');
include('src/BarcodeGeneratorJPG.php');
include('src/BarcodeGeneratorHTML.php');

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
$generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();

echo $generatorSVG->getBarcode('081231723897', $generatorPNG::TYPE_MSI_CHECKSUM);
echo "<br>";
echo "<br>";
echo "<br>";

echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('12345671234', $generator::TYPE_CODE_128)) . '">';
echo "<br>";
echo "<br>";
echo "<br>";
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('12345671234', $generator::TYPE_CODE_93)) . '">';
echo "<br>";
echo "<br>";
echo "<br>";
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('12345671234', $generator::TYPE_STANDARD_2_5)) . '">';
echo "<br>";
echo "<br>";
echo "<br>";
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('12345671234', $generator::TYPE_UPC_E)) . '">';
echo "<br>";
echo "<br>";
echo "<br>";

echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('12345671234', $generator::TYPE_CODE_93)) . '">';


?>