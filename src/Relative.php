<?php
namespace DateRange;

class Relative
{
    /**
     * @var array
     */
    private $options = array(
        'length' => '30 DAY',
        'modify' => '-1 DAY',
        'interval' => 'P1D',
        'date_format' => 'Y-m-d'
    );

    /**
     * @var \DateTime
     */
    private $firstDate;

    /**
     * @var \DateTime
     */
    private $lastDate;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);

        //init dates
        $this->firstDate = new \DateTime('NOW -'.$this->getOpt('length', '30 DAY'));
        $this->firstDate->modify($this->getOpt('modify', '-7 DAY'));

        $this->lastDate = new \DateTime('NOW');
        $this->lastDate->modify($this->getOpt('modify', '-0 DAY'));
    }

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    protected function getOpt($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setOpt($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * @param \DateTime $date
     */
    public function setFirstDate(\DateTime $date)
    {
        $this->firstDate = $date;
    }

    /**
     * @return \DateTime
     */
    public function getFirstDate()
    {
        return $this->firstDate;
    }

    /**
     * @param \DateTime $date
     */
    public function setLastDate(\DateTime $date)
    {
        $this->lastDate = $date;
    }

    /**
     * @return \DateTime
     */
    public function getLastDate()
    {
        return $this->lastDate;
    }

    /**
     * @return \DateInterval
     */
    public function getInterval()
    {
        return new \DateInterval($this->getOpt('interval', 'P1D'));
    }

    /**
     * @return array
     */
    public function getRange()
    {
        //dateperiod does not include the last date but we want it so offset again to include it
        $lastDay = clone $this->getLastDate();
        $lastDay->add($this->getInterval());

        $datePeriod = new \DatePeriod($this->getFirstDate(), $this->getInterval(), $lastDay);
        foreach ($datePeriod as $day) {
            $range[$day->format($this->getOpt('date_format'))] = array(
                'raw' => $day,
                'formatted' => $day->format($this->getOpt('date_format'))
            );
        }
        return $range;
    }
}
