<?php

namespace PageMill\Action;

class ActionTest extends \PHPUnit_Framework_TestCase {

    public function testConstructor() {
        $a = new Action(
            "GET",
            "/",
            []
        );

        $this->assertEquals(
            "PageMill\Action\Action",
            get_class($a)
        );
    }

    public function testSetDomainCallable() {
        $a = new Action(
            "GET",
            "/",
            []
        );
        $a->set_domain(function($a, $b, array $c){});

        $this->assertEquals(
            "PageMill\Action\Action",
            get_class($a)
        );
    }

    public function testExecuteDomain() {
        $a = new Action(
            "GET",
            "/",
            []
        );
        $a->set_domain(function($a, $b, array $c) {
            return "Success";
        });
        $return = $a->execute_domain(
            "GET",
            "/",
            []
        );

        $this->assertEquals(
            "Success",
            $return
        );
    }

    public function testSetResponderCallable() {
        $a = new Action(
            "GET",
            "/",
            []
        );
        $a->set_responder(function(array $c){});

        $this->assertEquals(
            "PageMill\Action\Action",
            get_class($a)
        );
    }

    public function testExecuteResponder() {
        $a = new Action(
            "GET",
            "/",
            []
        );
        $a->set_responder(function(array $c) {
            echo "Success";
        });
        ob_start();
        $a->execute_responder([]);
        $return = ob_get_clean();

        $this->assertEquals(
            "Success",
            $return
        );
    }

}
