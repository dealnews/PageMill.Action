<?php

namespace PageMill\Action;

/**
 * Abstract Action class
 *
 * Provides the basic needs of an Action class
 */

abstract class AbstractAction {

    protected $method = "";
    protected $request_path = "";
    protected $input = array();

    protected $domain = null;
    protected $responder = null;

    /**
     * Creates a new action object
     *
     * @param  string $method       The HTTP request method
     * @param  string $request_path The HTTP URL path
     * @param  array  $input        Input values other than method and path
     */
    public function __construct($method, $request_path, $input) {
        $this->method = $method;
        $this->request_path = $request_path;
        $this->input = $input;
    }

    /**
     * Executes the action by doing any action work, building domain data
     * and then executing the responder.
     *
     * @return void
     */
    public function __invoke() {
        $this->execute_responder(
            $this->execute_domain($this->method, $this->request_path, $this->input)
        );
    }

    /**
     * Child classes should override this method to execute the domains
     * and build the response data. The child class should understand
     * what the domain is and how to execute it.
     *
     * The method should set $this->data using data from the domain.
     *
     * @param  array  $input  Input values
     *
     * @return array  An array of data to be sent to the responders
     */
    abstract protected function execute_domain($method, $request_path, array $input);

    /**
     * Child classes should override this method execute the array of
     * repsonders. The child class should understand what the responders are
     * and how to execute them.
     *
     * @param  array  $data       Array of data to be use do generate
     *                            repsonses
     *
     * @return void
     */
    abstract protected function execute_responder(array $data);

}
