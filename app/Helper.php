<?php

namespace App;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class Helper
{
    public static function paginate($per_page, $page, $array)
    {
        $pagination = new LengthAwarePaginator(
            array_slice($array->toArray(), ($page - 1) * $per_page, $per_page),
            count($array),
            $per_page,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return $pagination;
    }

    function maskCep($val)
    {
        $mask = $this->mask($val, '#####-###');

        return $mask;
    }

    function maskDoc($val)
    {
        if (Str::length($val) === 11) {
            $mask = $this->mask($val, '###.###.###-##');
        } else {
            $mask = $this->mask($val, '##.###.###/####-##');
        }

        return $mask;
    }

    function maskPhone($val)
    {
        if (Str::length($val) === 8) {
            $mask = $this->mask($val, '####-####');
        } else {
            $mask = $this->mask($val, '#####-####');
        }

        return $mask;
    }

    static function brl2decimal($brl, $casasDecimais = 2)
    {
        if (preg_match('/^\d+\.{1}\d+$/', $brl))
            return (float) number_format($brl, $casasDecimais, '.', '');
        $brl = preg_replace('/[^\d\.\,]+/', '', $brl);
        $decimal = str_replace('.', '', $brl);
        $decimal = str_replace(',', '.', $decimal);
        return (float) number_format($decimal, $casasDecimais, '.', '');
    }

    function mask($val, $mask = null)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }

        return $maskared;
    }
}
