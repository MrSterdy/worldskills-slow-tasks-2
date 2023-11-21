<?php

function removeDuplicatesFrom(array $arr) {
    /**
     * пришлось юзать обычный массив, так как значение
     * может быть объектом, а пхп не позволяет использовать
     * объекты как ключи
     *
     * получилась бы неплохая хэш таблица
     */
    $result = [];
    $acknowledged = [];

    foreach ($arr as $value) {
        if (!in_array($value, $acknowledged)) {
            $result[] = $value;
            $acknowledged[] = $value;
        }
    }

    return $result;
}

echo implode(', ', removeDuplicatesFrom([1, 2, 3])), PHP_EOL;
echo implode(', ', removeDuplicatesFrom([1, 3, 3, 4, 6, 4, 5, 1])), PHP_EOL;
echo implode(', ', removeDuplicatesFrom([1, 3, 'val', 4, 6, 4, 'value', 'value'])), PHP_EOL;
