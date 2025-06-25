/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';

if (!$loader) {
    $loader = require __DIR__ . '/../../../../vendor/autoload.php';
}
\BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer::disableCache();
$loader->addPsr4('BitWasp\\Bitcoin\\Tests\\', __DIR__);
