<?php

function task1($xmlData)
{
    foreach ($xmlData as $value) {
       if ($value->count() < 1) {
            echo $value->getName() . ':', $value->__toString() . '<br>'; // нет детей, значит текст
        } else {
            echo $value->getName() . ':' . '<br>'; //есть дети, поэтому выводится только название ключа
            task1($value);
        }
  //    var_dump(get_class($value), $key, $value->count());
    }

}

task1(simplexml_load_file('data.xml'));


function task2()
{
    $data = [
        ["Россия", "США", "Испания", "Австралия"],
        ["США", "Испания", "Австралия", "Россия"],
        ["Россия", "США", "Испания", "Австралия"],
    ];
    $encoded = json_encode($data, JSON_UNESCAPED_UNICODE);
    file_put_contents('output.json', $encoded); // записываем первый файл
    echo 'Файл output был успешно записан <br>';
    $dat = file_get_contents('output.json');
    $data2 = json_decode($dat, true); // кодируем в простой массив
    $action = rand(1, 2);
    echo $action;
    if ($action == 1) {
        array_push($data2, "apple", "raspberry"); // добавляем в массив новые данные
        $encoded = json_encode($data2, JSON_UNESCAPED_UNICODE);
        file_put_contents('output2.json', $encoded); // записываем обновленный файл в output2.json
        echo 'Файл output2 был успешно записан';
    } else {
        file_put_contents('output2.json', $encoded); // записываем файл, но такой же, как и первый
        echo 'Запись output2 не была осуществленна, файл остался неизменным <br>';
    }
    echo '<h2>Прочитаем первый массив</h2>';
    $item1 = file_get_contents('output.json');
    echo "<br><br><pre>";
    $array1 = json_decode($item1, true);
    print_r($item1);
    echo '<h2>Прочитаем второй массив</h2>';
    $item2 = file_get_contents('output2.json');
    echo "<br><br><pre>";
    $array2 = json_decode($item2, true);
    echo $item2;

    echo '<h2>Найдем рассхождения</h2>';
if (sizeof($array2) > sizeof($array1)){
    $tmp = $array1; // своп, меняем переменный местами? поменяли массивы местами
    $array1 = $array2;
    $array2 = $tmp;
}
    foreach ($array1 as $key => $value) {
        if (isset($array2[$key])) {
            $result = array_diff($value, $array2[$key]); // не показывает разницу
            if (!empty($result)) {
                echo 'Изменения есть <br>';
                print_r($result);
            }
        }else{
            echo 'Изменения есть <br>';
            print_r($value);
        }
    }
}

task2();

function task3($name)
{
    $array = [];
    for ($i = 0; $i < 50; $i++) {
        $array[$i] = rand(1, 100);
    }
    $fp = fopen($name, "w");
    fputcsv($fp, $array, ';');
    fclose($fp);
    $csvFile = fopen($name, "r");
    $csvData = fgetcsv($csvFile, 200, ";");
    $sum = 0;
    echo '<pre>';
    print_r($csvData);
    foreach ($csvData as $key => $value) {
        if ($value % 2 == 0) {
            $sum = $sum + $value;
        }
    }
    echo "<br>", "Сумма четных чисел равна: " . $sum;
}

task3('csv.csv');


function task4()
{
    $data = file_get_contents('https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json');
    $decoded = json_decode($data, true);
    $params = ["title", "pageid"];
    echo '<pre>';
    $result = array_shift($decoded["query"]["pages"]);
//    print_r($result);
    foreach ($params as $value) {
        echo "<br>", $value . " = " . $result[$value];
    }
}

task4();