<?php
namespace DateRange;

class RelativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Range
     */
    private $object;

    public function setUp()
    {
        $this->object = new Relative();
    }

    public function testGetFirstDateReturnsDateTime()
    {
        $date = $this->object->getFirstDate();
        $this->assertTrue($date instanceof \DateTime);
    }

    public function testGetFirstDateReturnsNonOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'-0 day'));
        $date = $dataset->getFirstDate();
        $this->assertEquals(date('Y-m-d', strtotime('now -7 days')), $date->format('Y-m-d'));
    }

    public function testGetFirstDateReturnsNegativeOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'-1 day'));
        $date = $dataset->getFirstDate();
        $this->assertEquals(date('Y-m-d', strtotime('now -8 days')), $date->format('Y-m-d'));
    }

    public function testGetFirstDateReturnsPositiveOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'+1 day'));
        $date = $dataset->getFirstDate();
        $this->assertEquals(date('Y-m-d', strtotime('now -6 days')), $date->format('Y-m-d'));
    }

    public function testGetLastDateReturnsDateTime()
    {
        $date = $this->object->getLastDate();
        $this->assertTrue($date instanceof \DateTime);
    }

    public function testGetLastDateReturnsNonOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'-0 day'));
        $date = $dataset->getLastDate();
        $this->assertEquals(date('Y-m-d', strtotime('now')), $date->format('Y-m-d'));
    }

    public function testGetLastDateReturnsNegativeOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'-1 day'));
        $date = $dataset->getLastDate();
        $this->assertEquals(date('Y-m-d', strtotime('now -1 day')), $date->format('Y-m-d'));
    }

    public function testGetLastDateReturnsPositiveOffsetDate()
    {
        $dataset = new Relative(array('length'=>'7 DAY', 'modify'=>'+1 day'));
        $date = $dataset->getLastDate();
        $this->assertEquals(date('Y-m-d', strtotime('now +1 day')), $date->format('Y-m-d'));
    }

    public function testGetRangeReturnsArray()
    {
        $this->assertTrue(is_array($this->object->getRange()));
    }

    public function testGetRangeContainsExpectedKeys()
    {
        $this->object->setFirstDate(\DateTime::createFromFormat('Y-m-d', '2014-01-01'));
        $this->object->setLastDate(\DateTime::createFromFormat('Y-m-d', '2014-01-03'));

        $range = $this->object->getRange();
        $this->assertEquals(array('2014-01-01', '2014-01-02', '2014-01-03'), array_keys($range));
    }

    public function testGetRangeContainsExpectedDates()
    {
        $this->object->setFirstDate(\DateTime::createFromFormat('Y-m-d', '2014-01-01'));
        $this->object->setLastDate(\DateTime::createFromFormat('Y-m-d', '2014-01-03'));

        $range = $this->object->getRange();
        $this->assertEquals('2014-01-01', $range['2014-01-01']['formatted']);
        $this->assertEquals('2014-01-02', $range['2014-01-02']['formatted']);
        $this->assertEquals('2014-01-03', $range['2014-01-03']['formatted']);
    }

    public function testNDayOffsetReturnsExpectedDates()
    {
        $this->object->setFirstDate(\DateTime::createFromFormat('Y-m-d', '2014-01-01'));
        $this->object->setLastDate(\DateTime::createFromFormat('Y-m-d', '2014-01-05'));
        $this->object->setOpt('interval', 'P2D');

        $range = $this->object->getRange();
        $this->assertEquals('2014-01-01', $range['2014-01-01']['formatted']);
        $this->assertEquals('2014-01-03', $range['2014-01-03']['formatted']);
        $this->assertEquals('2014-01-05', $range['2014-01-05']['formatted']);
    }

    public function testMonthOffsetReturnsExpectedDates()
    {
        $this->object->setFirstDate(\DateTime::createFromFormat('Y-m-d', '2014-01-01'));
        $this->object->setLastDate(\DateTime::createFromFormat('Y-m-d', '2014-03-01'));
        $this->object->setOpt('interval', 'P1M');

        $range = $this->object->getRange();
        $this->assertEquals('2014-01-01', $range['2014-01-01']['formatted']);
        $this->assertEquals('2014-02-01', $range['2014-02-01']['formatted']);
        $this->assertEquals('2014-03-01', $range['2014-03-01']['formatted']);
    }
}
