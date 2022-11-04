# Currencies
Based on ISO-4217

## Implementation

```bash
composer require mibo/px
```

### Requirements
* PHP ^8.0
* illuminate/support ^9.36

## Usage

```php
// Load the user that has permissions.
/** @var \MiBo\PX\Contracts\HasPermissionsInterface $user */
$user;

if ($user->hasPermission("my.own.permission")) {
    // Do some action
} else {
    // You may log that the user is missing required permission.
}
```

When implementing the interface, consider to use provided trait. If doing so,
call `registerPermissions` method with all available permissions for the user:
```php
class MyUser implements \MiBo\PX\Contracts\HasPermissionsInterface
{
    use \MiBo\PX\Contracts\HasPermissionsTrait;
    
    public function __construct()
    {
        $this->registerPermissions(
            [
                "my.own.permission",
                "my.another.permission"
            ]
        );
    }
}
```
