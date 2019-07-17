<?php
namespace MageDevTools\Logger\Handler;
use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Formatter\LineFormatter;

class Monolog extends \Magento\Framework\Logger\Monolog {

    public function __construct( $name, array $handlers = [], array $processors = [] ) {
        parent::__construct( $name, $handlers, $processors );
        $this->pushProcessor(function ($record) {
            $record['channel'] = "{$this->getTraceId()} ".$record['channel'];
            return $record;
        });
    }

    public function getTraceId() {
        static $traceId = null;
        if (empty($traceId)) {
            $traceId = strtoupper(uniqid('', false));
        }
        return $traceId;
    }
}