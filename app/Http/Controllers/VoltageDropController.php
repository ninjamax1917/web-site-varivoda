<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoltageDropRequest;
use App\Services\CableCalculator;
use Illuminate\Http\Request;

class VoltageDropController extends Controller
{
    public function show()
    {
        return view('calculate.voltage_drop', [
            'devMode' => false,
            'voltage' => config('cable.voltage'),
            'method' => config('cable.method'),
            'materials' => config('cable.materials'),
            'sections' => config('cable.sections'),
            'number_of_cables' => config('cable.number_of_cables'),
            'result' => session('result'),
        ]);
    }

    public function calculate(VoltageDropRequest $request, CableCalculator $calc)
    {
        $data = $request->validated();

        if (empty($data['voltageValue'])) {
            $data['voltageValue'] = $calc->defaultVoltage($data['voltage']);
        }

        $result = $calc->calculate($data);

        if ($request->ajax()) {
            return back()->withInput()->with('result', $result);
        }

        return back()->with('result', $result);
    }
}
