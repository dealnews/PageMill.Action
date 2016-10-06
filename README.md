# PageMill Action

## Basic Example

```
use PageMill\Action\Action;

$action = new Action(
    "GET",
    "/",
    []
);

$action->set_domain(function($a, $b, array $c) {
    return ["Hi!"];
});

$action->set_responder(function(array $data) {
    echo $data[0];
});

$action->__invoke();
```