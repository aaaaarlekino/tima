<?php

function send_tg_message($message){

    // Токен вашего бота, полученный от BotFather
    $botToken = "7272058754:AAGBR4-4c_9HV_iKCZnK-f10_C2vB8MN560";
    // ID чата, в который вы хотите отправить сообщение
    $chatId = "5087902213";

    // URL для API запроса
    $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";

    // Параметры запроса
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    // Инициализируем cURL-сессию
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    // Выполняем запрос и получаем ответ от сервера
    $response = curl_exec($ch);

    // Закрываем cURL-сессию
    curl_close($ch);
}
?>
