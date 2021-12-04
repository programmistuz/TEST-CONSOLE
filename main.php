<?php

$main_array = ['vasya', 'pupkin', 'apple', 23, 41, 55, 1, 2];

// подготовка переданных аргументов
$args = preparationArgs($argv);

echo "В массиве булевское значение true: " . (analizHaveTrue($main_array) ? "есть" : "нет") . PHP_EOL;
echo "Во входящих параметрах булевское значение true: " . (analizHaveTrue($args) ? "есть" : "нет") . PHP_EOL;

echo PHP_EOL;
echo "Обьединенный массив и переданные параметры:" . PHP_EOL;
var_dump(array_merge($main_array, $args));

echo PHP_EOL;
echo "Нет данных в массиве:" . PHP_EOL;
var_dump(array_diff($main_array, $args));

echo PHP_EOL;
echo "Нет данных в передеанных параметрах:" . PHP_EOL;
var_dump(array_diff($args, $main_array));

echo PHP_EOL;
echo "Массив в верхнем регистре:" . PHP_EOL;
var_dump(arrUpper($main_array));

echo PHP_EOL;
echo "Толькот цифры в переданных параметрах:" . PHP_EOL;
var_dump(arrNumeric($args));

echo PHP_EOL;
echo "Массив, отсортированный по числам:" . PHP_EOL;
usort($main_array, "custom_sort");
var_dump($main_array);

/**
 * ----------------------------------------------------------
 * подготовка переданных аргументов
 * ----------------------------------------------------------
 * @param array $getArgs
 * @return array
 */
function preparationArgs(array $getArgs): array
{
    foreach ($getArgs as $key => $value) {
        // преобразование символьной строки в число (целое или десятичное)
        if (is_numeric($value)) $getArgs[$key] = makeNumeric($value);
        // преобразование символьной строки в логическое выражение
        $getArgs[$key] = makeBool($value);
    }

    return $getArgs;
}

/**
 * ----------------------------------------------------------
 * проверка наличия булевского значение true
 * ----------------------------------------------------------
 * @param array $getArr
 * @return bool
 */
function analizHaveTrue(array $getArr): bool
{
    $property = false;
    foreach ($getArr as $value) {
        if (gettype($value) === 'boolean' and $value === true) $property = true;
    }

    return $property;
}

/**
 * ----------------------------------------------------------
 * преобразование символьной строки в число (целое или десятичное)
 * ----------------------------------------------------------
 * @param string $getStr
 * @return string|integer|float
 */
function makeNumeric(string $getStr)
{
    $type = strpos($getStr, ".") === false ? 'integer' : 'float';
    settype($getStr, $type);

    return $getStr;
}

/**
 * ----------------------------------------------------------
 * преобразование символьной строки в логическое выражение
 * ----------------------------------------------------------
 * @param string $getStr
 * @return bool|string
 */
function makeBool(string $getStr)
{
    if ($getStr === 'true') $getStr = true;
    if ($getStr === 'false') $getStr = false;

    return $getStr;
}

/**
 * ----------------------------------------------------------
 * перевод в верхний регистр
 * ----------------------------------------------------------
 * @param array $getArr
 * @return array
 */
function arrUpper(array $getArr): array
{
    foreach ($getArr as $key => $value) {
        if (gettype($value) === 'string') $getArr[$key] = strtoupper($value);
    }

    return $getArr;
}

/**
 * ----------------------------------------------------------
 * получить только цифры
 * ----------------------------------------------------------
 * @param array $getArr
 * @return array
 */
function arrNumeric(array $getArr): array
{
    $arr = [];
    foreach ($getArr as $value) {
        // преобразование символьной строки в число (целое или десятичное)
        if (is_numeric($value)) $arr [] = makeNumeric($value);
    }

    return $arr;
}

/**
 * ----------------------------------------------------------
 * пользовательская сортировка (числа наверху)
 * ----------------------------------------------------------
 * @param $word_a
 * @param $word_b
 * @return int
 */
function custom_sort($word_a, $word_b)
{
    if (is_numeric($word_a) and !is_numeric($word_b)) {
        return 1;
    }
    if (!is_numeric($word_a) and is_numeric($word_b)) {
        return 1;
    }
    if (makeNumeric($word_a) < makeNumeric($word_b)) {
        return -1;
    } elseif (makeNumeric($word_a) > makeNumeric($word_b)) {
        return 1;
    } else {
        return 0;
    }
}