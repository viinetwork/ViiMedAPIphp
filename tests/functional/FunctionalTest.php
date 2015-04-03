<?php

abstract class FunctionalTest extends \Codeception\TestCase\Test
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected $_events = [];

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    protected function assertFieldsExistOnObject(StdClass $obj, array $fields)
    {
        foreach($fields as $field)
        {
            $this->assertTrue( isset($obj->{$field}) );
        }
    }

    protected function listenForEvents()
    {
        $dispatcher = $this->tester->grabService('Illuminate\\Events\\Dispatcher');
        $dispatcher->listen("*", function($event) use ($dispatcher) {
            $this->_events[$dispatcher->firing()] = $event;
        });
    }

    protected function assertEventFired($eventname, $message = NULL)
    {
        $message = $message ?: "$eventname event was not fired.";
        return $this->assertTrue( isset($this->_events[$eventname]), $message);
    }
}