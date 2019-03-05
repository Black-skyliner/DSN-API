# Connet to DSN REST API

The DSN API is the interface that allows the declarant's payroll software to authenticate directly to the filing point of the nominative social declarations without having to navigate to the net-entreprises.fr website to deposit and view its declarations.

# Authentication

```php
$payload = '<identifiants>
                <siret>' . $siret  . '</siret>
                <nom>' . $lastname . '</nom>
                <prenom>' . $firstname . '</prenom>
                <motdepasse>' . $password . '</motdepasse>
                <service>25</service>
            </identifiants>';
```
