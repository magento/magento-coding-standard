# Rule: Adminhtml controllers must inject `Magento\Backend\App\Action\Context`
## Background
`Magento\Backend\App\Action` requires `Magento\Backend\App\Action\Context`, which provides the authorization, auth session and backend URL used for admin access checks. `Magento\Framework\App\Action\Context` is the storefront context. A controller that injects it usually extends a storefront action and so has no admin protection.

## How it works
Only action classes are checked (see `Magento2.Security.AdminhtmlControllerAuthorization`), and only a `__construct()` declared in the class itself, so a class that inherits a valid constructor is never reported. Parameter types are resolved through the namespace and imports, including aliases.
- `FrameworkContext`: a parameter typed `Magento\Framework\App\Action\Context`.
- `InvalidContext`: a parameter passed to `parent::__construct()` whose type is another class named `Context`, for example `Magento\Framework\View\Element\Template\Context`.

A `Context` dependency that is not passed to the parent constructor is not reported, and neither is a constructor that does not call the parent constructor.

Invalid:
```php
use Magento\Framework\App\Action\Context;

class Delete extends \Magento\Backend\App\Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
```

Valid:
```php
use Magento\Backend\App\Action\Context;

class Delete extends \Magento\Backend\App\Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
```

## How to fix
Inject `Magento\Backend\App\Action\Context` and pass it to the parent constructor. `phpcbf` fixes `FrameworkContext` only when the change is unambiguous:
- the parent is `Magento\Backend\App\Action` or `Magento\Backend\App\AbstractAction`, whose constructors take the backend context
- the parameter is passed to `parent::__construct()`
- one of the following is true:
  - the type is written fully qualified, in which case the type is replaced
  - the type comes from a single, non-grouped import used nowhere else in the file, in which case the import is replaced

In all other cases the error is reported for a manual fix. A controller that extends a storefront action also needs its parent changed (see `Magento2.Security.AdminhtmlControllerAuthorization`).
