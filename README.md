### Connect to the DSN REST API  
The DSN API allows the declarant's payroll software to authenticate directly to the filing point of the nominative social declarations without access to [Net-Entreprise portal](net-entreprises.fr) for viewing and downloading documents.

#### Authentification
This function takes in parameters four inputs:  
- **SIRET** number
- **Lastname** and **firstname** of the declarant  
- Net-entreprise account **password**

```php
public function DSN($siret, $lastname, $firstname, $password)
{
  // See the PHP file for more details.
}
