# Rule: Adminhtml controllers must inherit from `Magento\Backend\App\Action`
## Background
Admin authentication is applied by the `adminAuthentication` plugin on `Magento\Backend\App\AbstractAction`, and ACL is checked by `_isAllowed()` in the same class. A class under `Controller/Adminhtml/` that extends `Magento\Framework\App\Action\Action`, a storefront action such as `Magento\Customer\Controller\AbstractAccount`, or no parent at all is still routed by the admin router, but neither check runs. Anyone who knows the admin URL can call it.

## Reasoning
Inheriting from `Magento\Backend\App\Action` is what makes an admin controller require a logged-in admin user and an allowed ACL resource. A short class name is not enough: `Magento\Framework\App\Action\Action` is also imported as `Action`, so the sniff resolves the fully qualified parent name.

## How it works
Every named class in a file whose path contains `/Controller/Adminhtml/` (either path separator) is checked when it can be dispatched as an action. A class counts as an action when one of these is true:
- the class or a resolved parent declares `execute()` and has a parent itself;
- the class or a resolved parent implements an `*ActionInterface`;
- the first parent that cannot be resolved has a `\Controller\` namespace or `Action` in its class name.

A class without a parent counts as an action only when it implements an `*ActionInterface`.

Helpers, plugins and loaders that live in the same directory (for example `Product\Initialization\Helper` or a `DataObject` loader) are ignored, because the router only dispatches classes that implement `Magento\Framework\App\ActionInterface`. Anonymous classes, interfaces and traits are ignored too.

The parent name is resolved using the namespace, `use` imports (including aliases and grouped imports), and `namespace\` relative names. The inheritance chain is then followed:
- A class declared in the same file is followed.
- A class in the same module is loaded from disk. Its path is derived from the namespace-to-directory mapping of the scanned file, for example `Vendor\Module\Controller\Adminhtml\AbstractAction` maps to `<module>/Controller/Adminhtml/AbstractAction.php`.
- The chain is valid when it reaches `Magento\Backend\App\Action`, `Magento\Backend\App\AbstractAction` (where the authentication plugin is declared), or a class from `allowedParentClasses`. It is also valid when it ends at a Magento Adminhtml controller (`Magento\<Module>\Controller\Adminhtml\*`) whose file is outside the scanned module. When the file can be read, as in Magento's own code, its chain is followed instead.
- A missing parent gives `MissingParent`. A parent that leads anywhere else, or that cannot be resolved, gives `InvalidParent`.

Valid:
```php
use Magento\Backend\App\Action as BackendAction;

class Index extends BackendAction
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}
```

Invalid:
```php
use Magento\Framework\App\Action\Action;

class Index extends Action
{
}
```

## How to fix
Extend `Magento\Backend\App\Action`, or a base class that extends it. Inject `Magento\Backend\App\Action\Context` (see `Magento2.Security.AdminhtmlControllerContext`) and declare `ADMIN_RESOURCE` (see `Magento2.Security.AdminhtmlControllerAcl`).

## Exceptions
A base class from another module cannot be resolved, because only the scanned module is read. Add it to the allowed list:
```xml
<rule ref="Magento2.Security.AdminhtmlControllerAuthorization">
    <properties>
        <property name="allowedParentClasses" type="array">
            <element value="Vendor\Base\Controller\Adminhtml\AbstractAction"/>
        </property>
    </properties>
</rule>
```
A single class can be excluded with `// phpcs:ignore Magento2.Security.AdminhtmlControllerAuthorization.InvalidParent`, and paths with `<exclude-pattern>`.
