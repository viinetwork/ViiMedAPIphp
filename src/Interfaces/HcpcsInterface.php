<?php
namespace Viimed\PhpApi\Interfaces;

interface HcpcsInterface
{
	public function findCodeCurrentVersion($code);
    
    public function findCodeVersion($code, $version);

    public function getAllCodeVersions($code);

    public function searchCurrentVersion(Array $queryParams);

    public function searchVersion($version, Array $queryParams);

    public function searchAllVersions(Array $queryParams);
}