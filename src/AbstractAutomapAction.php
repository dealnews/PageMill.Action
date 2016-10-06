<?php

namespace PageMill\Action;

/**
 * Helper class for automatically finding domain and responder classes
 * based on the same class name as the Action class name.
 */

abstract class AbstractAutomapAction extends Action {

    public function __invoke() {
        $called_class = get_called_class();
        if (substr($called_class, -(strlen("Action"))) == "Action") {
            $base_class = substr($called_class, 0, -(strlen("Action")));
        } else {
            throw new Exception\InvalidAction("Action class name does not match the convention. Must end in the word 'Action'.");
        }
        $this->set_domain($base_class."Domain");
        $this->set_responder($base_class."Responder");
        parent::__invoke();
    }
}
