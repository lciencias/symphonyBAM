<?php

/*use Symfony\Component\ClassLoader\UniversalClassLoader;

//$libPath = '/usr/share/php';
$libPath = '/xampp/htdocs/library';
require_once "$libPath/Symfony/Component/ClassLoader/UniversalClassLoader.php";

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => $libPath,
    'Query'   => $libPath,
    'ZFriendly'   => 'lib/zfriendly/src/',
    'Automatic'   => 'lib/automatic/src/',
    'PHPeriod'    => 'lib/phperiod/src/',
    'EasyCSV'     => 'lib/easycsv/src/',
    'Application' => '.',
));
$loader->registerPrefix("Zend_", $libPath);
$loader->register();

return $loader;*/

use Symfony\Component\ClassLoader\UniversalClassLoader;

$libPath = '/usr/share/php';
$libPath = '/var/www/library';

require_once "$libPath/Symfony/Component/ClassLoader/UniversalClassLoader.php";

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
		'Symfony' => $libPath,
		'Query'   => $libPath,
		'ZFriendly'   => 'lib/zfriendly/src/',
		'Automatic'   => 'lib/automatic/src/',
		'PHPeriod'    => 'lib/phperiod/src/',
		'EasyCSV'     => 'lib/easycsv/src/',
		'Application' => '.',
));
$loader->registerPrefix("Zend_", $libPath);
$loader->register();

return $loader;

