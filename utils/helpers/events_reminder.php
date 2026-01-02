<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventAttendee;

function createGoogleCalendarEventWithUsers($eventData, $platformUsers)
{
    $config = require __DIR__ . '/../../config/google_calendar.php';

    $client = new Client();
    $client->setAuthConfig($config['credentials_path']);
    $client->setScopes([Calendar::CALENDAR]);
    $client->setAccessType('offline');

    $service = new Calendar($client);

    $startDate = date('Y-m-d', strtotime($eventData['event_date']));
    $endDate   = date('Y-m-d', strtotime($eventData['event_date'] . ' +1 day'));

    $attendees = [];
    foreach ($platformUsers as $user) {
        if (!empty($user['email'])) {
            $attendees[] = new EventAttendee(['email' => $user['email']]);
        }
    }

    $googleEvent = new Event([
        'summary'     => $eventData['title'],
        'description' => $eventData['description'],
        'start' => ['date' => $startDate],
        'end'   => ['date' => $endDate],
        'attendees' => $attendees,
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60], 
                ['method' => 'popup', 'minutes' => 60], 
            ],
        ],
    ]);

    return $service->events->insert(
        $config['calendar_id'],
        $googleEvent
    );
}
?>