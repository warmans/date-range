<?php
namespace DateRange;

/**
 * Generates an array of dates relative to the current date.
 *
 * @package DateRange
 */
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
     * Get an option.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    protected function getOpt($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * Update an options.
     *
     * @param $name
     * @param $value
     */
    public function setOpt($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Override the start point i.e. the first date in the array.
     *
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
     * Override the end point (defaults to NOW)
     *
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
     * Get the DateInterval instance generated using the provided config.
     *
     * @return \DateInterval
     */
    public function getInterval()
    {
        return new \DateInterval($this->getOpt('interval', 'P1D'));
    }

    /**
     * Get the range as defined by given options.
     *
     * @return array
     */
    public function getRange()
    {
        //dateperiod does not include the last date but we want it so offset again to include it
        $lastDay = clone $this->getLastDate();
        $lastDay->add($this->getInterval());

        $datePeriod = new \DatePeriod($this->getFirstDate(), $this->getInterval(), $lastDay);

        $range = array();
        foreach ($datePeriod as $day) {
            $range[$day->format($this->getOpt('date_format'))] = array(
                'raw' => $day,
                'formatted' => $day->format($this->getOpt('date_format'))
            );
        }
        return $range;
    }
}
