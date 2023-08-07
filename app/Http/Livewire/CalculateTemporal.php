<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CalculateTemporal extends Component
{
    public $temporal = [
        "Exploit Code Maturity (E)" => [
            "id" => "temporal_E",
            "Not Defined (X)" => 23,
            "Unproven (U)" => 23,
            "Proof-of-Concept (P)" => 23,
            "Functionnal (F)" => 23,
            "High (H)" => 23
        ],
        "Remediation Level (RL)" => [
            "id" => "temporal_RL",
            "Not Defined (X)" => 23,
            "Official Fix (O)" => 23,
            "Temporary Fix (O)" => 23,
            "Workaround (W)" => 23,
            "Unavailable (U)" => 23
        ],
        "Report Confidence (RC)" => [
            "id" => "temporal_RC",
            "Not Defined (X)" => 23,
            "Unknown (U)" => 23,
            "Reasonable (R)" => 23,
            "Confirmed (C)" => 23
        ],
    ];
    public function render()
    {
        return view('livewire.calculate-temporal');
    }
}
