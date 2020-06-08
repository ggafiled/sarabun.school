<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DocumentType extends Enum
{
    const Confused = 0;
    const Sending = 1;
    const Receiving = 2;
    const Command = 3;
    const Memorandum = 4;
}