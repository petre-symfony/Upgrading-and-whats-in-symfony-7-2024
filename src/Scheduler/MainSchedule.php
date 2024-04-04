<?php

namespace App\Scheduler;

use App\Message\LogHello;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface {
	public function __construct(private CacheInterface $cache) {
	}

	public function getSchedule(): Schedule {
		return (new Schedule())->add(
			RecurringMessage::every('4 seconds', new LogHello(4)),
			RecurringMessage::every('3 seconds', new LogHello(3))
		)->stateful($this->cache);
	}
}