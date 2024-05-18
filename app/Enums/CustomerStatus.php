<?php
/**
 * User: Vega
 * Date: 12/02/2024
 * Time: 16:56pm
 */

namespace App\Enums;

enum CustomerStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
}