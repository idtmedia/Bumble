<?php
// make sure to update the path to where you cloned the projects to!
$path = '/path/to/libraries';
require_once PACZ_THEME_PLUGINS_CONFIG . '/minify/src/Minify.php';
require_once PACZ_THEME_PLUGINS_CONFIG . '/minify/src/CSS.php';
require_once PACZ_THEME_PLUGINS_CONFIG . '/minify/src/JS.php';
require_once PACZ_THEME_PLUGINS_CONFIG . '/minify/src/Exception.php';
//require_once $path . '/minify/src/Exceptions/BasicException.php';
//require_once $path . '/minify/src/Exceptions/FileImportException.php';
//require_once $path . '/minify/src/Exceptions/IOException.php';
//require_once $path . '/path-converter/src/ConverterInterface.php';
require_once PACZ_THEME_PLUGINS_CONFIG . '/minify/src/Converter.php';


use MatthiasMullie\Minify;

$sourcePath = PACZ_THEME_STYLES.'/pacz-styles.css';
$minifier = new Minify\CSS($sourcePath);

// we can even add another file, they'll then be
// joined in 1 output file
$sourcePath2 = PACZ_THEME_STYLES.'/header.css';
$minifier->add($sourcePath2);

// or we can just add plain CSS
$css = 'body { color: #000000; }';
$minifier->add($css);

// save minified file to disk
$minifiedPath = '/path/to/minified/css/file.css';
$minifier->minify($minifiedPath);

// or just output the content
echo $minifier->minify();
    /* css files for combining */
    //include(PACZ_THEME_STYLES.'/pacz-styles.css');
	//include(PACZ_THEME_STYLES.'/header.css');
   // include(PACZ_THEME_STYLES.'/footer.css');
	//include(PACZ_THEME_STYLES.'/pacz-blog.css');
