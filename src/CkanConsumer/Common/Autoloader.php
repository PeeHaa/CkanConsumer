<?php
/**
 * PSR-0 Autoloader
 *
 * PHP version 5.4
 *
 * @category   CkanConsumer
 * @package    Common
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CkanConsumer\Common;

/**
 * PSR-0 Autoloader
 *
 * @category   CkanConsumer
 * @package    Common
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Autoloader
{
    /**
     * @var string The namespace prefix for this instance.
     */
    protected $namespace = '';

    /**
     * @var string The filesystem prefix to use for this instance
     */
    protected $path = '';

    /**
     * Build the instance of the autoloader
     *
     * @param string $namespace The prefixed namespace this instance will load
     * @param string $path      The filesystem path to the root of the namespace
     */
    public function __construct($namespace, $path)
    {
        $this->namespace = ltrim($namespace, '\\');
        $this->path      = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * Try to load a class
     *
     * @param string $class The class name to load
     *
     * @return boolean If the loading was successful
     */
    public function load($class)
    {
        $class = ltrim($class, '\\');

        if (strpos($class, $this->namespace) === 0) {
            $path = $this->getPath($class);

            if (file_exists($path)) {
                require $path;
            }
        }
    }

    /**
     * Gets the full path to the file of the class
     *
     * @param string $class The fully qualified class name
     *
     * @return boolean The full path to the class file
     */
    private function getPath($class)
    {
        $path      = explode('\\', $class);
        $className = str_replace('_', '/', array_pop($path));

        return $this->path . implode('/', $path) . '/' . $className . '.php';
    }

    /**
     * Register the autoloader to PHP
     *
     * @return boolean The status of the registration
     */
    public function register()
    {
        return spl_autoload_register([$this, 'load']);
    }

    /**
     * Unregister the autoloader to PHP
     *
     * @return boolean The status of the unregistration
     */
    public function unregister()
    {
        return spl_autoload_unregister([$this, 'load']);
    }
}
