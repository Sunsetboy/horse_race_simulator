<?php


namespace App\Helpers;

/**
 * Helper to simulate time going
 * Class FakeTime
 * @package App\Helpers
 */
class FakeTime
{
    /**
     * @var integer
     */
    private $currentTimeStamp;

    /**
     * @var FakeTime
     */
    private static $instance;

    protected function __construct()
    {
        if (!file_exists(self::getFilePath())) {
            $this->currentTimeStamp = time();
            file_put_contents(self::getFilePath(), $this->currentTimeStamp);
        } else {
            $this->currentTimeStamp = file_get_contents(self::getFilePath());
        }
    }

    /**
     * Path to the file with fake timestamp
     * @return string
     */
    public static function getFilePath()
    {
        return __DIR__ . '/../../time.txt';
    }

    /**
     * @return $this|FakeTime
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @return int
     */
    public function get()
    {
        return $this->currentTimeStamp;
    }

    /**
     * @param $timeStamp
     */
    public function set($timeStamp)
    {
        $this->currentTimeStamp = $timeStamp;
        file_put_contents(self::getFilePath(), $this->currentTimeStamp);
    }

    public function increment($seconds)
    {
        $this->currentTimeStamp += (int)$seconds;
        $this->set($this->currentTimeStamp);
    }

    /**
     * Resets fake time to real
     */
    public function reset()
    {
        $this->currentTimeStamp = time();
        unlink(self::getFilePath());
    }
}
