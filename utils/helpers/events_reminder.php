<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
class GoogleCalendarService{
    public function createGoogleEvent($eventData) {
    $config = require __DIR__ . '/../../config/google_calendar.php';

    $client = new Client();
    $client->setAuthConfig($config['credentials_path']);
    $client->setScopes([Calendar::CALENDAR]);
    $client->setAccessType('offline');

    $service = new Calendar($client);

    $startDate = date('Y-m-d', strtotime($eventData['event_date']));
    $endDate   = date('Y-m-d', strtotime($eventData['event_date'] . ' +1 day'));

    $event = new Event([
        'summary'     => $eventData['title'],
        'description' => $eventData['description'] ?? '',
        'start'       => ['date' => $startDate],
        'end'         => ['date' => $endDate],
        'reminders'   => [
            'useDefault' => true
        ]
    ]);

    try {
        $createdEvent = $service->events->insert($config['calendar_id'], $event);

        return [
            'success'   => true,
            'event_id'  => $createdEvent->getId(),
            'html_link' => $createdEvent->getHtmlLink()
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'error'   => $e->getMessage()
        ];
    }
    }
    function updateGoogleEvent($newData, $eventId) {
    $config = require __DIR__ . '/../../config/google_calendar.php';

    $client = new \Google\Client();
    $client->setAuthConfig($config['credentials_path']);
    $client->setScopes([\Google\Service\Calendar::CALENDAR]);
    $client->setAccessType('offline');

    $service = new \Google\Service\Calendar($client);

    $event = $service->events->get($config['calendar_id'], $eventId);

    if (isset($newData['title'])) $event->setSummary($newData['title']);
    if (isset($newData['description'])) $event->setDescription($newData['description']);

    if (isset($newData['event_date'])) {
        $startDateTime = date('c', strtotime($newData['event_date']));
        $endDateTime   = date('c', strtotime($newData['event_date'] . ' +1 day'));
        $event->setStart(new EventDateTime(['dateTime' => $startDateTime, 'timeZone' => 'UTC']));
        $event->setEnd(new EventDateTime(['dateTime' => $endDateTime, 'timeZone' => 'UTC']));
    }

    $updatedEvent = $service->events->update($config['calendar_id'], $eventId, $event);

    return [
        'success' => true,
        'html_link' => $updatedEvent->getHtmlLink()
    ];
}
}
?>

