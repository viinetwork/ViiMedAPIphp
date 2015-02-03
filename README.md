# ViiMedAPIphp
ViiMed API Adaptor (PHP)

### Code Example
```
<?php

use Viimed\ViimedAPI\Viimed;


$viimed = Viimed::connect('ViiPartnerID', 'ViiPartnerSecret', 'ViiClientID);

// Get token
$Identifier = 'ViimedUser';
$IdentifierID = 42;

$Token = $viimed->generateToken( $Identifier, $IdentifierID) ;

...
// Validate Token
try{
	$boolean = $viimed->validateToken( $Token, $Identifier, $IdentifierID );
}
catch(Viimed\ViimedAPI\Exceptions\InvalidTokenException $e)
{
	// Token failed validation
}

...
// Destroy Token
$viimed->destroyToken( $Token );


?>

```