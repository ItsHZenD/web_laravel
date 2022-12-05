<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StudentStatusEnum extends Enum
{
    public const DI_HOC = 1;
    public const BO_HOC = 2;
    public const BAO_LUU = 3;

    public static function getArrayView(){
        return [
            'Đi học' => self::DI_HOC,
            'Bỏ học' => self::BO_HOC,
            'Bảo lưu' => self::BAO_LUU,
        ];
    }

    public static function getKeyByValue($value){
        return array_search($value, self::getArrayView(), true);
    }
}

