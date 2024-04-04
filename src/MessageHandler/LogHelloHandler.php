<?php

namespace App\MessageHandler;

use App\Message\LogHello;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LogHelloHandler {
	public function __invoke(LogHello $message) {
		// do something with your message
	}
}