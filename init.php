<?php

include("vendor/autoload.php");
include("TelegramBot.php");
include("Weather.php");

$telegramApi = new TelegramBot();
$weatherApi = new Weather();

while (true) {

    sleep(3);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {
        if (isset($update->message->location)) {

            $result = $weatherApi->getWeather($update->message->location->latitude, $update->message->location->longitude);

            switch ($result->weather[0]->main) {
                case "Clear":
                    $response = "На улице безоблачно. Зонтик не нужен";
                    break;
                case "Clouds":
                    $response = "На улице облачно. Зонтик нужно взять";
                    break;
                case "Rain":
                    $response = "На улице дождь. Зонтик берите обязательно";
                    break;
                default:
                    $response = "Ситуация непонятная решайте сами";
                    break;
            }

            $telegramApi->sendMessage($update->message->chat->id, $response);

        } else {
            $telegramApi->sendMessage($update->message->chat->id, "Please, send location!");
        }
    }

}

