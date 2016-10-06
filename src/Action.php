<?php

namespace PageMill\Action;

/**
 * Action class
 *
 * Provides the basic needs of an Action class
 */

class Action extends AbstractAction {

    /**
     * Set the class or function to use for the domain
     *
     * @param mixed $domain Either a class or function to use for the domain
     *
     * @throws InvalidDomain
     */
    public function set_domain($domain) {
        if (is_callable($domain)) {
            $re_func = new \ReflectionFunction($domain);
            $params = $re_func->getParameters();
            if (count($params) != 3) {
                throw new Exception\InvalidDomain("Domain does not accept three parameters");
            }
            if (!$params[2]->isArray()) {
                throw new Exception\InvalidDomain("Domain does not accept an array for parameter three");
            }
        }
        $this->domain = $domain;
    }

    /**
     * Set the class or function to use for the responder
     *
     * @param mixed $responder Either a class or function to use for the responder
     *
     * @throws InvalidResponder
     */
    public function set_responder($responder) {
        if (is_callable($responder)) {
            $re_func = new \ReflectionFunction($responder);
            $params = $re_func->getParameters();
            if (count($params) != 1) {
                throw new Exception\InvalidResponder("Responder does not accept exactly one parameter");
            }
            if (!$params[0]->isArray()) {
                throw new Exception\InvalidResponder("Responder does not accept an array for parameter one");
            }
        }
        $this->responder = $responder;
    }

    /**
     * Executes the domain and returns an array of data
     *
     * @param  string $method       The HTTP request method
     * @param  string $request_path The HTTP URL path
     * @param  array  $input        Input values other than method and path
     *
     * @throws InvalidDomain
     *
     * @return array  An array of data to be sent to the responders
     */
    public function execute_domain($method, $request_path, array $input) {
        if (is_callable($this->domain)) {
            $func = $this->domain;
            $data = $func($method, $request_path, $input);
        } elseif (
            is_string($this->domain) &&
            class_exists($this->domain) &&
            method_exists($this->domain, "__invoke")
        ) {
            $class = $this->domain;
            $d = new $class($method, $request_path, $input);
            $data = $d->__invoke();
        } else {
            throw new Exception\InvalidDomain("Domain could not be executed");
        }
        return $data;
    }

    /**
     * Executes the responder
     *
     * @throws InvalidResponder
     *
     * @return void
     */
    public function execute_responder(array $data) {
        if (is_callable($this->responder)) {
            $func = $this->responder;
            $func($data);
        } elseif (
            is_string($this->responder) &&
            class_exists($this->responder) &&
            method_exists($this->responder, "__invoke")
        ) {
            $class = $this->responder;
            $d = new $class($data);
            $d->__invoke();
        } else {
            throw new Exception\InvalidResponder("Responder could not be executed");
        }
    }
}
