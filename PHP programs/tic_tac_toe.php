<?php // крестики-нолики с умным компом (super_smart) и в конце спрашивает хотите ли сыграть еще раз 

function first_player_move()
{
  global $arr_with_fields, $str_with_fields, $arr_of_user_moves;
  do {
    $user_move = readline("It's your move first. Type any field from the list: $str_with_fields : "); // $user_move = $_POST['user_move'];
  } while (!in_array($user_move, $arr_with_fields));  // будет предлагать выбрать вариант пока юзер не выберет правильный
  echo "You played $user_move.\n";
  sleep(1);
  if (($key = array_search($user_move, $arr_with_fields)) !== false) {
    array_push($arr_of_user_moves, $arr_with_fields[$key]); // добавляем значение в массив ходов игрока
    unset($arr_with_fields[$key]);  // удаляем выбранное игроком значение из массива полей, узнав перед этим ключ
  }
  $str_with_fields = str_replace($user_move, '', $str_with_fields); // убираем значение из строки полей
}

function first_comp_move()
{
  global $arr_with_fields, $str_with_fields, $arr_of_comp_moves;
  echo "It's computer move first. He chooses from the list: $str_with_fields\n";
  // так как это первый ход то комп просто рандомно выбирает ход
  sleep(1);
  $computer_move = array_rand(array_flip($arr_with_fields)); // return it to client
  echo "Computer played $computer_move.\n";
  sleep(1);
  if (($key = array_search($computer_move, $arr_with_fields)) !== false) {
    array_push($arr_of_comp_moves, $arr_with_fields[$key]); // добавляем значение в массив ходов компа
    unset($arr_with_fields[$key]); // убираем из массива возможных ходов
  }
  $str_with_fields = str_replace($computer_move, '', $str_with_fields); // убираем из строки возможных ходов
}

function computer_turn()
{
  global $arr_with_fields, $str_with_fields, $arr_of_user_moves, $arr_of_comp_moves, $win_arr1, $win_arr2, $win_arr3, $win_arr4, $win_arr5, $win_arr6, $win_arr7, $win_arr8, $game_done;
  echo "Now it's computer's turn to move. He chooses from the list: $str_with_fields\n";
  sleep(1);

  // реализовать выигр стр-гию самому
  if (count(array_intersect($arr_of_comp_moves, $win_arr1)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr1, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr1, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr2)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr2, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr2, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr3)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr3, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr3, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr4)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr4, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr4, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr5)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr5, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr5, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr6)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr6, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr6, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr7)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr7, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr7, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_comp_moves, $win_arr8)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr8, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr8, $arr_of_comp_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);

    // теперь не дать реализовать выигр стр-гию игроку
  } else if (count(array_intersect($arr_of_user_moves, $win_arr1)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr1, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr1, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr2)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr2, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr2, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr3)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr3, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr3, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr4)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr4, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr4, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr5)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr5, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr5, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr6)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr6, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr6, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr7)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr7, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr7, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);
  } else if (count(array_intersect($arr_of_user_moves, $win_arr8)) == 2 && (in_array(array_rand(array_flip(array_diff($win_arr8, $arr_of_user_moves))), $arr_with_fields))) {
    $computer_move = array_rand(array_flip(array_diff($win_arr8, $arr_of_user_moves)));
    echo "Computer played $computer_move.\n";
    sleep(1);

    // если нигде не было двух пересечений то просто сыграй рандомно  
  } else {
    $computer_move = array_rand(array_flip($arr_with_fields));
    echo "Computer played $computer_move.\n";
    sleep(1);
  }

  // добавляем значение в массив ходов компа и удаляем из массива ходов
  if (($key = array_search($computer_move, $arr_with_fields)) !== false) {
    array_push($arr_of_comp_moves, $arr_with_fields[$key]); // добавляем 
    unset($arr_with_fields[$key]); // удаляем
    // print_r($arr_of_comp_moves);
    // print_r($arr_with_fields);
  }
  $str_with_fields = str_replace($computer_move, '', $str_with_fields);
  // echo $str_with_fields;

  // check if computer won
  if (empty(array_diff($win_arr1, $arr_of_comp_moves)) || empty(array_diff($win_arr2, $arr_of_comp_moves)) || empty(array_diff($win_arr3, $arr_of_comp_moves)) || empty(array_diff($win_arr4, $arr_of_comp_moves)) || empty(array_diff($win_arr5, $arr_of_comp_moves)) || empty(array_diff($win_arr6, $arr_of_comp_moves)) || empty(array_diff($win_arr7, $arr_of_comp_moves)) || empty(array_diff($win_arr8, $arr_of_comp_moves))) {
    echo "Computer won!\n";
    $game_done = true;
    sleep(1);
  }
}

function player_turn()
{
  global $arr_with_fields, $str_with_fields, $arr_of_user_moves, $win_arr1, $win_arr2, $win_arr3, $win_arr4, $win_arr5, $win_arr6, $win_arr7, $win_arr8, $game_done;
  do {
    $user_move = readline("Now it's your turn to play. Choose any field from the list: $str_with_fields : ");
  } while (!in_array($user_move, $arr_with_fields));
  echo "You played $user_move.\n";
  sleep(1);
  if (($key = array_search($user_move, $arr_with_fields)) !== false) {
    array_push($arr_of_user_moves, $arr_with_fields[$key]); // добавляем значение в массив ходов игрока
    unset($arr_with_fields[$key]);
  }
  $str_with_fields = str_replace($user_move, '', $str_with_fields);
  if (empty(array_diff($win_arr1, $arr_of_user_moves)) || empty(array_diff($win_arr2, $arr_of_user_moves)) || empty(array_diff($win_arr3, $arr_of_user_moves)) || empty(array_diff($win_arr4, $arr_of_user_moves)) || empty(array_diff($win_arr5, $arr_of_user_moves)) || empty(array_diff($win_arr6, $arr_of_user_moves)) || empty(array_diff($win_arr7, $arr_of_user_moves)) || empty(array_diff($win_arr8, $arr_of_user_moves))) {
    echo "Congratulations! You won!\n";
    sleep(1);
    $game_done = true;
  }
}

// main loop of the program
echo "Hello! This is tic-tac-toe game.\n";
sleep(1);
$game_number = 0;
$running = true;  // весь процесс игры кроме приветствия
while ($running) { // устанавливаем значение массивов (нужно здесь потому что иначе при повторной игре значения останутся старыми)
  $arr_with_fields = ['1a', '1b', '1c', '2a', '2b', '2c', '3a', '3b', '3c']; // массив всех значений игрового поля
  $str_with_fields = "1a, 1b, 1c, 2a, 2b, 2c, 3a, 3b, 3c";
  $win_arr1 = ['1a', '1b', '1c'];
  $win_arr2 = ['2a', '2b', '2c'];
  $win_arr3 = ['3a', '3b', '3c'];
  $win_arr4 = ['1a', '2a', '3a'];
  $win_arr5 = ['1b', '2b', '3b'];
  $win_arr6 = ['1c', '2c', '3c'];
  $win_arr7 = ['1a', '2b', '3c'];
  $win_arr8 = ['1c', '2b', '3a'];
  $arr_of_comp_moves = [];
  $arr_of_user_moves = [];
  $game_done = false; // когда кто-то выигрывает или ничья (т.е. есть результат игры), пока его нет
  $game_number++;
  echo "Game number " . $game_number . ".\n";
  sleep(1);
  if ($game_number % 2 != 0) {
    first_player_move();
  } else {
    first_comp_move();
  }

  while (!$game_done) {
    if ($game_number % 2 != 0) {
      computer_turn();
    } else {
      player_turn();
    }

    if (empty($arr_with_fields) && (!$game_done)) {
      echo "It's a tie!\n";
      $game_done = true;
      sleep(1);
    }

    if (!$game_done) {
      if ($game_number % 2 != 0) {
        player_turn();
      } else {
        computer_turn();
      }
      if (empty($arr_with_fields) && (!$game_done)) {
        echo "It's a tie!\n";
        $game_done = true;
        sleep(1);
      }
    }
  }
  if ($game_done) { // если кто-то выиграл или ничья, включи финальный вопрос
    $final = true;
    while ($final) {
      $final_decision = readline("Do you want to play again? y/n : ");
      if ($final_decision == 'y') {
        $final = false;
        $running = true;
      } else if ($final_decision == 'n') {
        $final = false;
        $running = false;
        echo "Game over!";  // выйти из игры
      } else {
        $final = true;
      }
    }
  }
}
