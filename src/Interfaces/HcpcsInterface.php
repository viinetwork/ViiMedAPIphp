<?php
namespace Viimed\PhpApi\Interfaces;

interface HcpcsInterface
{
	public function findCodeCurrentVersion($code);
    
    public function findCodeVersion($code, $version);

    public function getAllCodeVersions($code);

    public function searchCurrentVersion($queryParams);

    public function searchVersion($version, $queryParams);

    public function searchAllVersions($queryParams);
}