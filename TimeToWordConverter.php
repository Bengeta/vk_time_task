<?php

class TimeToWordConverter implements TimeToWordConvertingInterface
{
    private static $ten = array(
        array('', 'первого', 'второго', 'третьего', 'четвертого', 'пятого', 'шестого', 'седьмого', 'восьмого', 'девятого'),
        array('', 'одного', 'двух', 'трех', 'четырех', 'пяти', 'шести', 'семи', 'восьми', 'девяти'),
        array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
    );
    private static $a20 = array(
        array('десятого', 'одиннадцатого', 'двенадцатого'),
        array('десяти', 'одиннадцати', 'двенадцати'),
        array('десять', 'одиннадцать', 'двенадцать'),
    );
    private static $tens = array('двадцать');
    private static $unit = array(
        array('минута', 'минуты', 'минут', 1),
        array('час', 'часа', 'часов', 0),
    );
    private static $fraction = array('четверть', 'половина');

    private static $time_interval = array('до', 'после');

    public function convert(int $hours, int $minutes): string
    {
        if ($minutes === 0)
            return $this->get_integer($hours, 2) . " " . $this->get_last_time_word($hours, 1);

        elseif ($minutes === 15)
            return self::$fraction[0] . " " . $this->get_integer(($hours + 1) % 12, 0);

        elseif ($minutes === 30)
            return self::$fraction[1] . " " . $this->get_integer(($hours + 1) % 12, 0);

        else
            return $this->get_integer($minutes, 3) . " " . $this->get_last_time_word($minutes, 2)
                . " " . $this->get_time_interval($hours, $minutes);
    }

    private function get_last_time_word(int $digit, int $type): string
    {
        $a = -1;
        if ($digit % 10 === 1)
            $a = 0;
        elseif ($digit % 10 === 2 || $digit % 10 === 3 || $digit % 10 === 4)
            $a = 1;
        else
            $a = 2;

        return self::$unit[$type][$a];
    }

    private function get_integer(int $digit, int $type): string
    {
        if ($digit < 10)
            return self::$ten[$type][$digit];

        elseif ($digit > 9 && $digit < 20) {
            if ($type === 3)
                $type--;
            return self::$a20[$type][$digit % 10];
        } elseif ($digit === 20)
            return self::$tens[0];

        else
            return self::$tens[0] . " " . self::$ten[$type][$digit];
    }

    private function get_time_interval(int $hours, int $minutes): string
    {
        if ($minutes < 30)
            return self::$time_interval[0] . " " . $this->get_integer($hours, 1);
        else
            return self::$time_interval[1] . " " . $this->get_integer(($hours + 1) % 12, 1);
    }
}