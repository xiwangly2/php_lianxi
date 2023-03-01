<?php

class Snowflake {
    private $workerId;
    private $datacenterId;
    private $sequence = 0;
    private $lastTimestamp = -1;
    private $epoch = 1288834974657;

    private $workerIdBits = 5;
    private $datacenterIdBits = 5;
    private $maxWorkerId;
    private $maxDatacenterId;
    private $sequenceBits = 12;
    private $workerIdShift;
    private $datacenterIdShift;
    private $timestampLeftShift;
    private $sequenceMask;

    public function __construct($workerId, $datacenterId) {
        $this->maxWorkerId = -1 ^ (-1 << $this->workerIdBits);
        $this->maxDatacenterId = -1 ^ (-1 << $this->datacenterIdBits);
        $this->workerIdShift = $this->sequenceBits;
        $this->datacenterIdShift = $this->workerIdBits + $this->sequenceBits;
        $this->timestampLeftShift = $this->datacenterIdBits + $this->workerIdBits + $this->sequenceBits;
        $this->sequenceMask = -1 ^ (-1 << $this->sequenceBits);

        if ($workerId > $this->maxWorkerId || $workerId < 0) {
            throw new Exception("Invalid worker ID");
        }

        if ($datacenterId > $this->maxDatacenterId || $datacenterId < 0) {
            throw new Exception("Invalid datacenter ID");
        }

        $this->workerId = $workerId;
        $this->datacenterId = $datacenterId;
    }

    public function nextId() {
        $timestamp = $this->timeGen();

        if ($timestamp < $this->lastTimestamp) {
            throw new Exception("Clock moved backwards");
        }

        if ($timestamp == $this->lastTimestamp) {
            $this->sequence = ($this->sequence + 1) & $this->sequenceMask;

            if ($this->sequence == 0) {
                $timestamp = $this->tilNextMillis($this->lastTimestamp);
            }
        } else {
            $this->sequence = 0;
        }

        $this->lastTimestamp = $timestamp;

        $id = (($timestamp - $this->epoch) << $this->timestampLeftShift) |
                    ($this->datacenterId << $this->datacenterIdShift) |
                    ($this->workerId << $this->workerIdShift) |
                    $this->sequence;

        return $id;
    }

    private function timeGen() {
        return floor(microtime(true) * 1000);
    }

    private function tilNextMillis($lastTimestamp) {
        $timestamp = $this->timeGen();

        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }

        return $timestamp;
    }
}

// 使用示例
// $snowflake = new Snowflake(1, 1);
// echo $snowflake->nextId();
