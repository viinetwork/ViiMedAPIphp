<?php namespace Viimed\PhpApi\Interfaces;

interface SamlInterface
{
    public function metadata();
    public function login();
    public function logout();
    public function acs();
    public function sls();
}
