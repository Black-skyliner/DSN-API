### Connect to the DSN REST API  
The DSN API provides authentication service to declarants in order to  viewing and downloading declarations documents without having access to [net-entreprise portal](https://www.net-entreprises.fr/).

#### Authentification
This function requires 4 inputs:  
- **SIRET** number.
- **Lastname** and **firstname** of the declarant.
- Net-entreprise account **password**.

```php
public function DSN($siret, $lastname, $firstname, $password)
{
  // See PHP file for more details.
}
