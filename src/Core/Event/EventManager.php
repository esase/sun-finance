<?php

namespace SunFinance\Core\Event;

use Exception;
use SunFinance\Core\ServiceManager\ServiceManager;

class EventManager
{
    /**
     * @var array
     */
    protected $subscribers = [];

    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * EventManager constructor.
     *
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param string $event
     * @param string $className
     * @param string $method
     */
    public function subscribe(
        string $event,
        string $className,
        string $method
    ) {
        $this->subscribers[$event][] = [
            'class_name' => $className,
            'method'     => $method
        ];
    }

    /**
     * @param string $event
     * @param null   $data
     *
     * @throws Exception
     */
    public function trigger(string $event, $data = null)
    {
        // check subscribers
        if ($this->subscribers[$event]) {
            // notify subscribers
            foreach ($this->subscribers[$event] as $subscriber) {
                $instance = $this->serviceManager->getInstance(
                    $subscriber['class_name']
                );
                $instance->{$subscriber['method']}($data);
            }
        }
    }
}
