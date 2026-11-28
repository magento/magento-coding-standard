# Rule: Adminhtml controllers must declare a non-empty `ADMIN_RESOURCE`
## Background
`Magento\Backend\App\Action` checks `static::ADMIN_RESOURCE` in `_isAllowed()`. Its default value is `Magento_Backend::admin`, which every admin role has, so a controller that does not declare its own resource can be used by any admin user, whatever their role.

## Reasoning
Extending `Magento\Backend\App\Action` makes a controller require a login, but not authorization. Inheritance is checked by `Magento2.Security.AdminhtmlControllerAuthorization`, and this rule reports missing ACL separately.

## How it works
Every non-abstract named action class under `/Controller/Adminhtml/` is checked (see `Magento2.Security.AdminhtmlControllerAuthorization` for how action classes are detected). It passes when the class, or a parent resolved in the same file or module, declares one of:
- an `ADMIN_RESOURCE` constant with a non-empty value
- an `_isAllowed()` method

The parent chain is followed the same way as in `Magento2.Security.AdminhtmlControllerAuthorization`. Classes from `allowedParentClasses` are trusted to declare the resource. So are Magento Adminhtml controllers whose file is outside the scanned module; otherwise their declarations are checked.

Error codes:
- `MissingAdminResource`: no declaration was found before reaching `Magento\Backend\App\Action` or `Magento\Backend\App\AbstractAction`, a class that cannot be resolved, or no parent.
- `EmptyAdminResource`: the value is `''`.

Whether the resource exists in `etc/acl.xml` is not checked.

Valid:
```php
class Delete extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity_delete';
}
```

Invalid:
```php
class Delete extends \Magento\Backend\App\Action
{
}
```

## How to fix
Declare `public const ADMIN_RESOURCE = '<Vendor_Module::resource>';` with a resource defined in `etc/acl.xml`, or override `_isAllowed()`.

## Exceptions
Use the `allowedParentClasses` property (see `Magento2.Security.AdminhtmlControllerAuthorization`), `// phpcs:ignore Magento2.Security.AdminhtmlControllerAcl.MissingAdminResource`, or `<exclude-pattern>`.
