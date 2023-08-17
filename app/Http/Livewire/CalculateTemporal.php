<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CalculateTemporal extends Component
{
    public $exploit_code_matury = 1;
    public $report_confidence = 1;
    public $remediation_level = 1;
    public $score_base = null;
    
    public $score_temporal = null;
    public $severity_base = ["", ""];

    public $temporal = [
        "Exploit Code Maturity (E)" => [
            "id" => "temporal_E",
            "Not Defined (X)" => 1,
            "Unproven (U)" => 0.91,
            "Proof-of-Concept (P)" => 0.94,
            "Functionnal (F)" => 0.97,
            "High (H)" => 1
        ],
        "Remediation Level (RL)" => [
            "id" => "temporal_RL",
            "Not Defined (X)" => 1,
            "Official Fix (O)" => 0.95,
            "Temporary Fix (O)" => 0.96,
            "Workaround (W)" => 0.97,
            "Unavailable (U)" => 1
        ],
        "Report Confidence (RC)" => [
            "id" => "temporal_RC",
            "Not Defined (X)" => 1,
            "Unknown (U)" => 0.92,
            "Reasonable (R)" => 0.96,
            "Confirmed (C)" => 1
        ],
    ];


    public function recuperation($value, $id){
        switch ($id) {
            case "temporal_E":
                $this->exploit_code_matury = $value;
                break;
            case "temporal_RC":
                $this->report_confidence = $value;
                break;
            case "temporal_RL":
                $this->remediation_level = $value;
                break;
            default:
                echo "error";
        }

        $this->calculateTemporalScore();
    }

    public function calculateTemporalScore()
    {  
        $this->score_base = session('base');

        if($this->score_base){
            $this->score_temporal = roundUp($this->score_base * $this->exploit_code_matury *  $this->remediation_level * $this->report_confidence);
            if ($this->score_temporal == 0) {
                $this->score_temporal = $this->score_base;
            }
            $this->severity_base = ratingScale($this->score_temporal);
        }

       
    }

    
    public function render()
    {
        return view('livewire.calculate-temporal');
    }
}
