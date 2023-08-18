<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Livewire;

class Calculate extends Component
{
    /* METRIQUE 

            DE

        BASE
    */
    public $base_verified = [];
    public $ISS = 16;
    public $impact = 0;
    public $exploitability = 0;
    public $base_score = null;
    public $severity_base = ["", ""];


    public $attack_vector = 0;
    public $attack_complexity = 0;
    public $privilige_required = 0;
    public $user_interaction = 0;
    public $integrity = 0;
    public $scope = 0;
    public $confidentiality = 0;
    public $availability = 0;
    
    public $impact_conf = null;
    public $impact_integ = null;
    public $impact_avail = null;

    public $base = [
        "Attack Vector (AV)" => [
            "id" => "base_AV",
            "Network (N)" => 0.85,
            "Adjacent (A)" => 0.62,
            "Local (L)" => 0.55,
            "Physical (P)" => 0.2
        ],
        "Scope (S)" => [
            "id" => "base_S",
            "Unchanged (S)" => 0,
            "Changed (C)" => 1
        ],
        "Attack Complexity (AC)" => [
            "id" => "base_AC",
            "Low (L)" => 0.77,
            "High (H)" => 0.44
        ],
        "Confidentiality (C)" => [
            "id" => "base_C",
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "Privileges Required (PR)" => [
            "id" => "base_PR",
            "None (N)" => 0.85,
            "Low (L)" => 0.62, //(0.68 if Scope / Modified Scope is Changed)
            "High (H)" => 0.27 //(0.50 if Scope / Modified Scope is Changed)
        ],
        "Integrity (I)" => [
            "id" => "base_I",
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "User Interaction (UI)" => [
            "id" => "base_UI",
            "None (N)" => 0.85,
            "Required (R)" => 0.62
        ],
        "Availability (A)" => [
            "id" => "base_A",
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
    ];

/* METRIQUE 

            DE

        TEMPS
    */
    public $exploit_code_matury = 1;
    public $report_confidence = 1;
    public $remediation_level = 1;
    public $score_temporal = null;
    public $severity_temporal = ["", ""];

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
            "Temporary Fix (T)" => 0.96,
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



   
/* METRIQUE 

            

        ENVIRONNEMENT
    */
    public $MISS;
    public $ModifiedImpact = 1;
    public $ModifiedScope = 1;
    public $ModifiedAttackVector = 1;
    public $ModifiedAttackComplexity = 1;
    public $ModifiedPrivilegesRequired = 1;
    public $ModifiedUserInteraction = 1;
    public $ModifiedExploitability = 1;
    public $ExploitCodeMaturity = 1;
    public $RemediationLevel = 1;
    public $ReportConfidence = 1;
    public $ConfidentialityRequirement = 1;
    public $ModifiedConfidentiality = 1;
    public $IntegrityRequirement = 1;
    public $ModifiedIntegrity = 1;
    public $AvailabilityRequirement = 1;
    public $ModifiedAvailability = 1;

    public $EnvironmentalScore = null;

    public $severity_env = ["", ""];
    
    public $environmental  = [
        "Confidentiality Requirement (CR)" => [
            "id" => "env_CR",
            "Not Defined (X)" => 1,
            "Low (L)" => 0.5,
            "Medium (M)" => 1,
            "High (H)" => 1.5,
        ],
        "Integrity Requirement (IR)" => [
            "id" => "env_IR",
            "Not Defined (X)" => 1,
            "Low (L)" => 0.5,
            "Medium (M)" => 1,
            "High (H)" => 1.5,
        ],
        "Availability Requirement (AR)" => [
            "id" => "env_AR",
            "Not Defined (X)" => 1,
            "Low (L)" => 0.5,
            "Medium (M)" => 1,
            "High (H)" => 1.5,
        ],
        "Modified Attack Vector (MAV)" => [
            "id" => "env_MAV",
            "Not Defined (X)" => 1,
            "Network (N)" => 0.85,
            "Adjacent (A)" => 0.62,
            "Local (L)" => 0.55,
            "Physical (P)" => 0.2
        ],
        "Modified Attack Complexity (MAC)" => [
            "id" => "env_MAC",
            "Not Defined (X)" => 1,
            "Low (L)" => 0.77,
            "High (H)" => 0.44
        ],
        "Modified Privileges Required (MPR)" => [
            "id" => "env_MPR",
            "Not Defined (X)" => 1,
            "None (N)" => 0.85,
            "Low (L)" => 0.62, //(0.68 if Scope / Modified Scope is Changed)
            "High (H)" => 0.27 //(0.50 if Scope / Modified Scope is Changed)
        ],
        "Modified User Interaction (MUI)" => [
            "id" => "env_MUI",
            "Not Defined (X)" => 1,
            "None (N)" => 0.85,
            "Required (R)" => 0.62
        ],
        "Modified Scope (MS)" => [
            "id" => "env_MS",
            "Not Defined (X)" => 0,
            "Unchanged (S)" => 0,
            "Changed (C)" => 1
        ],
        "Modified Confidentiality (MC)" => [
            "id" => "env_MC",
            "Not Defined (X)" => 1,
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "Modified Integrity (MI)" => [
            "id" => "env_MI",
            "Not Defined (X)" => 1,
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "Modified Availability (MA)" => [
            "id" => "env_MA",
            "Not Defined (X)" => 1,
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
    ];

    public function recuperation($value, $id)
    {
        switch ($id) {
            case "base_AV":
                $this->attack_vector = $value;
                $this->select_case($id);
                break;
            case "base_AC":
                $this->attack_complexity = $value;
                $this->select_case($id);
                break;
            case "base_UI":
                $this->user_interaction = $value;
                $this->select_case($id);
                break;
            case "base_I":
                $this->integrity = $value;
                $this->select_case($id);
                break;
            case "base_S":
                if($value == 1 && $this->privilige_required  == 0.62){
                    $this->privilige_required = 0.68;
                }elseif($value == 1 && $this->privilige_required == 0.27 ){
                        $this->privilige_required = 0.5;
                    }
                if($value == 0 && $this->privilige_required  == 0.68){
                    $this->privilige_required = 0.62;
                }elseif($value == 0 && $this->privilige_required == 0.5 ){
                        $this->privilige_required = 0.27;
                    }
                $this->scope = $value;
                $this->select_case($id);
                break;
            case "base_PR":
                if($this->scope == 1 && $value == 0.62){
                    $this->privilige_required = 0.68;
                    $this->select_case($id);
                }elseif($this->scope == 1 && $value == 0.27 ){
                        $this->privilige_required = 0.5;
                        $this->select_case($id);
                    }else{
                        $this->privilige_required = $value;
                        $this->select_case($id);
                    }
                break;
            case "base_C":
                $this->confidentiality = $value;
                $this->select_case($id);
                break;
            case "base_A":
                $this->availability = $value;
                $this->select_case($id);
                break;

            // metrique temorelle
            case "temporal_E":
                $this->exploit_code_matury = $value;
                $this->calculateTemporalScore();
                break;
            case "temporal_RC":
                $this->report_confidence = $value;
                $this->calculateTemporalScore();
                break;
            case "temporal_RL":
                $this->remediation_level = $value;
                $this->calculateTemporalScore();
                break;
            default:
                echo "error";
        }
        
        
    }

    /*cette fonction permet de didentifer tous les elements choisis sur la 
    calculatrice, afin deffectuer un calcul quand tous les elements seront selectionnés*/
    public function select_case($element)
    {
        $this->dispatchBrowserEvent('test');
        if (!in_array($element, $this->base_verified)) {
            $this->base_verified[] = $element;
        }
            
        if(count($this->base_verified) == 8){
            $this->calculate_base_score();
        }
        
    }

    public function calculate_base_score(){
        $this->ISS = 1 - ( (1 - $this->confidentiality) * (1 - $this->integrity) * (1 - $this->availability) );
        if($this->scope == 0){
            $this->impact = 6.42 * $this->ISS;
        }else{
            $this->impact = 7.52 * ($this->ISS - 0.029) - 3.25 * ($this->ISS - 0.02)**15;
        }
       
        $this->exploitability = 8.22 * $this->attack_vector * $this->attack_complexity * $this->privilige_required * $this->user_interaction;
        
        if($this->impact < 0  || $this->impact == 0){
            $this->base_score = 0;
        }else{
            if($this->scope == 0){
                $this->base_score = roundUp(min(($this->impact + $this->exploitability), 10));
            }else{
                $this->base_score = roundUp(min(1.08 * ($this->impact  + $this->exploitability), 10));
            }
        }
        $this->severity_base = ratingScale($this->base_score);

        // jappelle la methode calcul de temporelscore et environnemental score
        $this->calculateTemporalScore();
        $this->CalculateEnvScore();

        $this->dispatchBrowserEvent('test');

        


    }

    public function calculateTemporalScore()
    {
        if($this->base_score !== null){
            $this->score_temporal = roundUp($this->base_score * $this->exploit_code_matury *  $this->remediation_level * $this->report_confidence);
            if ($this->score_temporal == 0) {
                $this->score_temporal = $this->base_score;
            }
            $this->severity_temporal = ratingScale($this->score_temporal);
        }
    }



    public function recuperation_env($value, $id)
    {
        switch ($id) {
            case "env_CR":
                $this->ConfidentialityRequirement = $value;
                break;
            case "env_IR":
                $this->IntegrityRequirement = $value;
                break;
            case "env_AR":
                $this->AvailabilityRequirement = $value;
                break;
            case "env_MAV":
                $this->ModifiedAttackVector = $value;
                break;
            case "env_MS":
                if($value == 1 && $this->ModifiedPrivilegesRequired  == 0.62){
                    $this->ModifiedPrivilegesRequired = 0.68;
                }elseif($value == 1 && $this->ModifiedPrivilegesRequired == 0.27 ){
                        $this->ModifiedPrivilegesRequired = 0.5;
                    }
                if($value == 0 && $this->ModifiedPrivilegesRequired  == 0.68){
                    $this->ModifiedPrivilegesRequired = 0.62;
                }elseif($value == 0 && $this->ModifiedPrivilegesRequired == 0.5 ){
                        $this->ModifiedPrivilegesRequired = 0.27;
                    }
                $this->ModifiedScope = $value;
                break;
            case "env_MPR":
                if($this->ModifiedScope == 1 && $value == 0.62){
                    $this->ModifiedPrivilegesRequired = 0.68;
                }elseif($this->ModifiedScope == 1 && $value == 0.27 ){
                        $this->ModifiedPrivilegesRequired = 0.5;
                    }else{
                        $this->ModifiedPrivilegesRequired = $value;
                    }
                break;
            case "env_MAC":
                $this->ModifiedAttackComplexity = $value;
                break;
            case "env_MUI":
                $this->ModifiedUserInteraction = $value;
                break;
            case "env_MC":
                $this->ModifiedConfidentiality = $value;
                break;
            case "env_MI":
                $this->ModifiedIntegrity= $value;
                break;
            case "env_MA":
                $this->ModifiedAvailability = $value;
                break;
            default:
                echo "error";
        }

        $this->CalculateEnvScore();
        
    }

    public function CalculMISS(): float
    {
        return min( 1 - ( 
                            (1 - $this->ConfidentialityRequirement * $this->ModifiedConfidentiality) *
                            (1 - $this->IntegrityRequirement * $this->ModifiedIntegrity) * 
                            (1 - $this->AvailabilityRequirement * $this->ModifiedAvailability ) 
                        ), 
                    0.915);
    }
    
    public function CalculateEnvScore()
    {
        if ($this->base_score !== null) {
            $this->MISS = $this->CalculMISS();

            if($this->ModifiedScope == 0){
                $this->ModifiedImpact = 6.42 * $this->MISS;
            }else{
                $this->impact = 7.52 * ($this->MISS - 0.029) - 3.25 * ($this->MISS * 0.9731 - 0.02)**13;
            }
    
            $this->ModifiedExploitability = 8.22 * $this->ModifiedAttackVector * 
                            $this->ModifiedAttackComplexity * $this->ModifiedPrivilegesRequired * 
                            $this->ModifiedUserInteraction;
    
            if($this->ModifiedImpact < 0  || $this->ModifiedImpact == 0){
                $this->EnvironmentalScore = 0;
            }else{
                if($this->ModifiedScope == 0){
                    $this->EnvironmentalScore = roundUp(
                                            roundUp(
                                                min(($this->ModifiedImpact + $this->ModifiedExploitability), 10)
                                                ) *
                                            $this->ExploitCodeMaturity * $this->RemediationLevel * $this->ReportConfidence   
                                        );
                }else{
                    $this->EnvironmentalScore = roundUp(
                        roundUp(
                            min(1.08 * ($this->ModifiedImpact  + $this->ModifiedExploitability), 10)
                            ) *
                        $this->ExploitCodeMaturity * $this->RemediationLevel * $this->ReportConfidence   
                    );
                }
            }
            $this->severity_env = ratingScale($this->EnvironmentalScore);
        }
       
    }
    
    public function render()
    {
        return view('livewire.calculate');
    }
}
