<?php

namespace App\Services;

class CableCalculator
{
    public function calculate(array $data): array
    {
        $materials = config('cable.materials');
        $sections = config('cable.sections');

        $TEMP_COEFF = (float) config('cable.temp_coeff', 0.004);
        $DEFAULT_TEMP = (float) config('cable.default_temp', 20);

        $voltageType = $data['voltage'];
        $methodType = $data['method'];
        $material = $data['material'];
        $section = $data['section'];

        $temperature = (float) $data['temperature'];
        $length = (float) $data['length'];
        $cosifi = (float) ($data['cosifi'] ?? 0);
        $voltageValue = (float) $data['voltageValue'];
        $number_of_cables = (int) ($data['number_of_cables'] ?? 1);

        if ($methodType === 'current') {
            $current = (float) $data['current'];
            $power = ($voltageValue * $current) / 1000;
        } else {
            $power = (float) $data['power'];
            $current = $voltageType === 'VOLTAGE_DC'
                ? $power / $voltageValue
                : $power / ($voltageValue * max($cosifi, 0.01));
        }

        $resistivity = $materials[$material];
        $sectionValue = $sections[$section];

        if ($temperature != $DEFAULT_TEMP) {
            $resistivity *= (1 + $TEMP_COEFF * ($temperature - $DEFAULT_TEMP));
        }

        if ($voltageType === 'VOLTAGE_AC_380') {
            $voltageDrop = (sqrt(3) * $length * $current * $resistivity) / ($sectionValue * $number_of_cables);
        } else {
            $voltageDrop = (2 * $length * $current * $resistivity) / ($sectionValue * $number_of_cables);
        }

        $voltageDropPercent = ($voltageDrop / $voltageValue) * 100;

        return [
            'voltageDrop_number' => round($voltageDrop, 2),
            'voltageDrop_percent' => round($voltageDropPercent, 2),
            'current' => round($current, 2),
            'power' => round($power, 2),
        ];
    }

    public function defaultVoltage(string $voltageType): int
    {
        return match ($voltageType) {
            'VOLTAGE_AC_220' => 220,
            'VOLTAGE_AC_380' => 380,
            default => 12,
        };
    }
}
