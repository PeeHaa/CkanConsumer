<?php
/**
 * This bootstraps the library
 *
 * PHP version 5.3
 *
 * @category   CkanConsumer
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CkanConsumer;

use CkanConsumer\Common\Autoloader;

require_once __DIR__ . '/src/CkanConsumer/Common/Autoloader.php';

$autoloader = new Autoloader(__NAMESPACE__, __DIR__ . '/src');
$autoloader->register();
