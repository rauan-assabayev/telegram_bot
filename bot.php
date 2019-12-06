<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // require_once('telegram-bot-sdk/vendor/autoload.php'); //Подключаем библиотеку

    // $token = "724280497:AAE-3tNu7x7ukIYqvcan0jA6NlWT0biOfAk";
    // $bot = new \TelegramBot\Api\Client('724280497:AAE-3tNu7x7ukIYqvcan0jA6NlWT0biOfAk');
    // // команда для start
    // $bot->command('start', function ($message) use ($bot) {
    //     $answer = 'Добро пожаловать!';
    //     $bot->sendMessage($message->getChat()->getId(), $answer);
    // });

    // // команда для помощи
    // $bot->command('help', function ($message) use ($bot) {
    //     $answer = 'Команды:
    // /help - вывод справки';
    //     $bot->sendMessage($message->getChat()->getId(), $answer);
    // });

    // if(!empty($bot->getRawBody())){
    //  echo 'hello';
    //      $bot->run();
    //  }



    include('bot/vendor/autoload.php'); //Подключаем библиотеку
    use Telegram\Bot\Api; 

    $telegram = new Api('724280497:AAE-3tNu7x7ukIYqvcan0jA6NlWT0biOfAk'); //Устанавливаем токен, полученный у BotFather
    $result = $telegram -> getWebhookUpdate(); //Передаем в переменную $result полную информацию о сообщении пользователя
    
    $text = $result["message"]["text"]; //Текст сообщения
    $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
    $name = $result["message"]["from"]["username"]; //Юзернейм пользователя
    $keyboard = [["Шаблон 1"],["Шаблон 2"],["Шаблон 3"]]; //Клавиатура
    $types = [["PDF"],["DOC"]]; //типы
    $pattern = 0;

    $keyboardTypes = [
                'inline_keyboard' => [
                    [
                        ['text' => 'pdf', 'callback_data' => 'pdf'],
                        ['text' => 'word', 'callback_data' => 'word']
                    ]
                ]
    ];



    
    $callback_query = $result->getCallbackQuery()->getData();

    if($callback_query == 'pdf'){
        $url = "http://visionofhumanity.org/app/uploads/2017/05/IPI-Positive-Peace-Report.pdf";
        $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Шаблон 2 PDF" ]);
    }


    if($text){
         if ($text == "/start") {
            $reply = "Добро пожаловать в бот марафон!";
            $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);

        }elseif ($text == "/help") {
            $reply = "Информация с помощью.";
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);

        }elseif ($text == "Шаблон 1") {
            
            $pattern = 1;
            $encodedKeyboard = json_encode($keyboardTypes);
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Выберите формат: ",'reply_markup' => $encodedKeyboard]); 

        }elseif ($text == "Шаблон 2") {
            
            $pattern = 2;   
            $encodedKeyboard = json_encode($keyboardTypes);
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Выберите формат: ",'reply_markup' => $encodedKeyboard]);   


   //          $url = "http://visionofhumanity.org/app/uploads/2017/05/IPI-Positive-Peace-Report.pdf";
   //          $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Шаблон 2 PDF" ]);

            // $url = "http://www.letters.org/letters/C74F5B-cute-romantic-love-letter.docx";
   //          $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Шаблон 2 WORD" ]);

        }elseif ($text == "Шаблон 3") {
    
            $pattern = 3;
            $encodedKeyboard = json_encode($keyboardTypes);
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Выберите формат: ",'reply_markup' => $encodedKeyboard]);     
                
        
        }elseif ($text == "PDF") {
            $url = "http://visionofhumanity.org/app/uploads/2017/05/IPI-Positive-Peace-Report.pdf";
            $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Шаблон 2 PDF" ]);

        }else{
            $reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
        }
    }else{
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
    }



?>