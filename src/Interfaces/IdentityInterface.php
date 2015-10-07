<?php namespace Viimed\PhpApi\Interfaces;

interface IdentityInterface
{
    public function registerIdentity($system_name, $system_id, Array $traits);
    public function findIdentity($system_name, $system_id);
}