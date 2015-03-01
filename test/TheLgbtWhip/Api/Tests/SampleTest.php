<?php

class SampleTest extends PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        // given
        $a = array();

        // when
        $a['test'] = true;

        // then
        $this->assertTrue($a['test']);
    }
} 