<?php namespace Hourglass\Core\File;


interface LoaderInterface
{
    public function load($environment, $group, $namespace = null);

    public function exists($group, $namespace = null);

    public function addNamespace($namespace, $hint);

    public function getNamespaces();

    public function cascadePackage($environment, $package, $group, $items);
}