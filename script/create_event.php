<?php
require_once __DIR__ . '../../vendor/autoload.php';
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

$config = require __DIR__ . '../../config/google_calendar.php';

$client = new Client();
$client->setAuthConfig($config['credentials_path']);
$client->setScopes([Calendar::CALENDAR]);
$client->setAccessType('offline');

$service = new Calendar($client);

$event = new Event([
    'summary' => 'Test Event',
    'description' => 'This is a test from the platform',
    'start' => ['dateTime' => '2026-01-15T10:00:00+01:00'],
    'end'   => ['dateTime' => '2026-01-15T11:00:00+01:00'],
]);

$createdEvent = $service->events->insert($config['calendar_id'], $event);
echo "Event created: " . $createdEvent->htmlLink;

?>