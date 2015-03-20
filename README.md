# ViiMedAPIphp
ViiMed API Adaptor (PHP)

### Code Example
```
<?php

use Viimed\PhpApi\API;


$gateway = API::connect('ViiPartnerID', 'ViiPartnerSecret', 'ViiClientID);

// Get token
$Identifier = 'ViimedUser';
$IdentifierID = 42;

$Token = $gateway->authSerivces()->generateToken( $Identifier, $IdentifierID) ;

...
// Validate Token
try{
	$boolean = $gateway->authSerivces()->validateToken( $Token, $Identifier, $IdentifierID );
}
catch(Viimed\ViimedAPI\Exceptions\InvalidTokenException $e)
{
	// Token failed validation
}

...
// Destroy Token
$gateway->authSerivces()->destroyToken( $Token );


?>

```

## Gateways
1. AuthService
2. Patients
3. GlobalUsers
4. Emrs

#### Code Example
```
//Patients
$allPatients = $gateway->patients->getAll();
$patient = $gateway->patients()->findById( $patientId );

//GlobalUsers
$limit = 10;
$offset = 0;
$allGlobalUsers = $gateway->globalUsers()->getAll( $limit, $offset );
$user = $gateway->globalUsers()->findById( $globaluserId );
$externalIDs = $user->externalIDs;

//or
$externalIDs = $gateway->globalUsers()->getExternalIDs( $globaluserId );

```