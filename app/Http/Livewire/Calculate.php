<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Livewire;

class Calculate extends Component
{
    public $vector_string_tab = [];
    public $vector_string = "";


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


    public $attack_vector = null;
    public $attack_complexity = null;
    public $privilige_required = null;
    public $user_interaction = null;
    public $integrity = null;
    public $scope = null;
    public $confidentiality = null;
    public $availability = null;
    
    public $impact_conf = null;
    public $impact_integ = null;
    public $impact_avail = null;

    public $base = [
        "Attack Vector (AV)" => [
            "id" => "AV",
            "Network (N)" => ["N", 0.85],
            "Adjacent (A)" => ["A",0.62],
            "Local (L)" => ["L", 0.55],
            "Physical (P)" => ["P", 0.2]
        ],
        "Scope (S)" => [
            "id" => "S",
            "Unchanged (U)" => ["U", 0],
            "Changed (C)" => ["C", 1]
        ],
        "Attack Complexity (AC)" => [
            "id" => "AC",
            "Low (L)" => ["L", 0.77],
            "High (H)" => ["H", 0.44]
        ],
        "Confidentiality (C)" => [
            "id" => "C",
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
        ],
        "Privileges Required (PR)" => [
            "id" => "PR",
            "None (N)" => ["N", 0.85],
            "Low (L)" => ["L", 0.62], //(0.68 if Scope / Modified Scope is Changed)
            "High (H)" => ["H", 0.27] //(0.50 if Scope / Modified Scope is Changed)
        ],
        "Integrity (I)" => [
            "id" => "I",
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
        ],
        "User Interaction (UI)" => [
            "id" => "UI",
            "None (N)" => ["N", 0.85],
            "Required (R)" => ["R", 0.62]
        ],
        "Availability (A)" => [
            "id" => "A",
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
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
            "id" => "E",
            "Not Defined (X)" => ["X", 1],
            "Unproven (U)" => ["U", 0.91],
            "Proof-of-Concept (P)" => ["P", 0.94],
            "Functionnal (F)" => ["F", 0.97],
            "High (H)" => ["H", 1]
        ],
        "Remediation Level (RL)" => [
            "id" => "RL",
            "Not Defined (X)" => ["X", 1],
            "Official Fix (O)" => ["O", 0.95],
            "Temporary Fix (T)" => ["T", 0.96],
            "Workaround (W)" => ["W", 0.97],
            "Unavailable (U)" => ["U", 1]
        ],
        "Report Confidence (RC)" => [
            "id" => "RC",
            "Not Defined (X)" => ["X", 1],
            "Unknown (U)" => ["U", 0.92],
            "Reasonable (R)" => ["R", 0.96],
            "Confirmed (C)" => ["C", 1]
        ],
    ];



   
/* METRIQUE 

            

        ENVIRONNEMENT
    */
    public $MISS;
    public $ModifiedImpact = 0;
    public $ModifiedScope = -1;
    public $ModifiedAttackVector = -1;
    public $ModifiedAttackComplexity = -1;
    public $ModifiedPrivilegesRequired = -1;
    public $ModifiedUserInteraction = -1;
    public $ModifiedExploitability = 0;
    public $ConfidentialityRequirement = 1;
    public $ModifiedConfidentiality = -1;
    public $IntegrityRequirement = 1;
    public $ModifiedIntegrity = -1;
    public $AvailabilityRequirement = 1;
    public $ModifiedAvailability = -1;

    public $EnvironmentalScore = null;

    public $severity_env = ["", ""];

    public $tab = [
        "ModifiedAttackVector" => -1,
        "ModifiedAttackComplexity" => -1,
        "ModifiedPrivilegesRequired"=> -1,
        "ModifiedUserInteraction" => -1,
        "ModifiedConfidentiality" => -1,
        "ModifiedIntegrity" => -1,
        "ModifiedAvailability" => -1,
        "ModifiedScope" => -1
    ];
    
    public $environmental  = [
        "Confidentiality Requirement (CR)" => [
            "id" => "CR",
            "Not Defined (X)" => ["X", 1],
            "Low (L)" => ["L", 0.5],
            "Medium (M)" => ["M", 1],
            "High (H)" => ["H", 1.5],
        ],
        "Integrity Requirement (IR)" => [
            "id" => "IR",
            "Not Defined (X)" => ["X", 1],
            "Low (L)" => ["L", 0.5],
            "Medium (M)" => ["M", 1],
            "High (H)" => ["H", 1.5],
        ],
        "Availability Requirement (AR)" => [
            "id" => "AR",
            "Not Defined (X)" => ["X", 1],
            "Low (L)" => ["L", 0.5],
            "Medium (M)" => ["M", 1],
            "High (H)" => ["H", 1.5],
        ],
        "Modified Attack Vector (MAV)" => [
            "id" => "MAV",
            "Not Defined (X)" => ["X", -1],
            "Network (N)" => ["N", 0.85],
            "Adjacent (A)" => ["A", 0.62],
            "Local (L)" => ["L", 0.55],
            "Physical (P)" => ["P", 0.2]
        ],
        "Modified Attack Complexity (MAC)" => [
            "id" => "MAC",
            "Not Defined (X)" => ["X", -1],
            "Low (L)" => ["L", 0.77],
            "High (H)" => ["H", 0.44]
        ],
        "Modified Privileges Required (MPR)" => [
            "id" => "MPR",
            "Not Defined (X)" => ["X", -1],
            "None (N)" => ["N", 0.85],
            "Low (L)" => ["L", 0.62], //(0.68 if Modified Scope is Changed)
            "High (H)" => ["H", 0.27] //(0.50 if Modified Scope is Changed)
        ],
        "Modified User Interaction (MUI)" => [
            "id" => "MUI",
            "Not Defined (X)" => ["X", -1],
            "None (N)" => ["N", 0.85],
            "Required (R)" => ["R", 0.62]
        ],
        "Modified Scope (MS)" => [
            "id" => "MS",
            "Not Defined (X)" => ["X", -1],
            "Unchanged (U)" => ["U", 0],
            "Changed (C)" => ["C", 1]
        ],
        "Modified Confidentiality (MC)" => [
            "id" => "MC",
            "Not Defined (X)" => ["X", -1],
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
        ],
        "Modified Integrity (MI)" => [
            "id" => "MI",
            "Not Defined (X)" => ["X", -1],
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
        ],
        "Modified Availability (MA)" => [
            "id" => "MA",
            "Not Defined (X)" => ["X", -1],
            "None (N)" => ["N", 0],
            "Low (L)" => ["L", 0.22],
            "High (H)" => ["H", 0.56]
        ],
    ];

    public function recuperation($value, $id, $lettre)
    {
        //si on n'appuie pas su le bouton NOT DEFINED
        $this->UpdateVectorString($id, $this->vector_string_tab, $lettre);
        
        switch ($id) {
            case "AV":
                $this->attack_vector = $value;
                if($this->tab["ModifiedAttackVector"]==-1){$this->ModifiedAttackVector = $this->attack_vector;}
                $this->select_case($id);
                break;
            case "AC":
                $this->attack_complexity = $value;
                if($this->tab["ModifiedAttackComplexity"]==-1){$this->ModifiedAttackComplexity = $this->attack_complexity;}
                $this->select_case($id);
                break;
            case "UI":
                $this->user_interaction = $value;
                if($this->tab["ModifiedUserInteraction"]==-1){$this->ModifiedUserInteraction = $this->user_interaction;}
                $this->select_case($id);
                break;
            case "I":
                $this->integrity = $value;
                if($this->tab["ModifiedIntegrity"]==-1){$this->ModifiedIntegrity = $this->integrity;}
                $this->select_case($id);
                break;
            case "S":
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
                if($this->tab["ModifiedScope"]==-1){$this->ModifiedScope = $this->scope;}
                if($this->tab["ModifiedPrivilegesRequired"]==-1){$this->ModifiedPrivilegesRequired = $this->privilige_required;}
                $this->select_case($id);
                break;
            case "PR":
                if($this->scope == 1 && $value == 0.62){
                    $this->privilige_required = 0.68;
                }elseif($this->scope == 1 && $value == 0.27 ){
                        $this->privilige_required = 0.5;
                    }else{
                        $this->privilige_required = $value;
                    }
                if($this->tab["ModifiedPrivilegesRequired"]==-1){$this->ModifiedPrivilegesRequired = $this->privilige_required;}
                $this->select_case($id);
                break;
            case "C":
                $this->confidentiality = $value;
                if($this->tab["ModifiedConfidentiality"]==-1){$this->ModifiedConfidentiality = $this->confidentiality;}
                $this->select_case($id);
                break;
            case "A":
                $this->availability = $value;
                if($this->tab["ModifiedAvailability"]==-1){$this->ModifiedAvailability = $this->availability;}
                $this->select_case($id);
                break;
            // metrique temorelle
            case "E":
                $this->exploit_code_matury = $value;
                $this->calculateTemporalScore();
                break;
            case "RC":
                $this->report_confidence = $value;
                $this->calculateTemporalScore();
                break;
            case "RL":
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
        if (!in_array($element, $this->base_verified)) {
            $this->base_verified[] = $element;
        }

        if(count($this->base_verified) == 8){
            $this->calculate_base_score();
        }
    }

    public function calculate_base_score()
    {
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

        $this->vector_string = $this->GenerateVectorString($this->vector_string_tab);
        
    }

    public function calculateTemporalScore()
    {
        if($this->base_score !== null){
            $this->score_temporal = roundUp($this->base_score * $this->exploit_code_matury *  $this->remediation_level * $this->report_confidence);
            if ($this->score_temporal == 0) {
                $this->score_temporal = $this->base_score;
            }
            $this->severity_temporal = ratingScale($this->score_temporal);
            
            $this->CalculateEnvScore();

            $this->vector_string = $this->GenerateVectorString($this->vector_string_tab);
        }
    }



    public function recuperation_env($value, $id, $lettre)
    {
        //si on n'appuie pas su le bouton NOT DEFINED
        $this->UpdateVectorString($id, $this->vector_string_tab, $lettre);

        switch ($id) {
            case "CR":
                $this->ConfidentialityRequirement = $value;
                break;
            case "IR":
                $this->IntegrityRequirement = $value;
                break;
            case "AR":
                $this->AvailabilityRequirement = $value;
                break;
            case "MAV":
                if($value==-1){$this->ModifiedAttackVector = $this->attack_vector; break;}
                $this->ModifiedAttackVector = $value;
                $this->tab["ModifiedAttackVector"] = 0;
                break;
            case "MS":
                if($value==-1){$this->ModifiedScope = $this->scope; break;}

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
                $this->tab["ModifiedScope"] = 0;
                break;
            case "MPR":
                if($value==-1){$this->ModifiedPrivilegesRequired = $this->privilige_required; break;}

                if($this->ModifiedScope == 1 && $value == 0.62){
                    $this->ModifiedPrivilegesRequired = 0.68;
                }elseif($this->ModifiedScope == 1 && $value == 0.27 ){
                        $this->ModifiedPrivilegesRequired = 0.5;
                    }else{
                        $this->ModifiedPrivilegesRequired = $value;
                    }
                $this->tab["ModifiedPrivilegesRequired"] = 0;
                break;
            case "MAC":
                if($value==-1){$this->ModifiedAttackComplexity = $this->attack_complexity; break;}
                $this->ModifiedAttackComplexity = $value;
                $this->tab["ModifiedAttackComplexity"] = 0;
                break;
            case "MUI":
                if($value==-1){$this->ModifiedUserInteraction = $this->user_interaction; break;}
                $this->ModifiedUserInteraction = $value;
                $this->tab["ModifiedUserInteraction"] = 0;
                break;
            case "MC":
                if($value==-1){$this->ModifiedConfidentiality = $this->confidentiality; break;}
                $this->ModifiedConfidentiality = $value;
                $this->tab["ModifiedConfidentiality"] = 0;
                break;
            case "MI":
                if($value==-1){$this->ModifiedIntegrity = $this->integrity; break;}
                $this->ModifiedIntegrity= $value;
                $this->tab["ModifiedIntegrity"] = 0;
                break;
            case "MA":
                if($value==-1){$this->ModifiedAvailability = $this->availability; break;}
                $this->ModifiedAvailability = $value;
                $this->tab["ModifiedAvailability"] = 0;
                break;
            default:
                echo "error";
        }

        $this->CalculateEnvScore();
        
        $this->vector_string = $this->GenerateVectorString($this->vector_string_tab);
        
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
                $this->ModifiedImpact = 7.52 * ($this->MISS - 0.029) - 3.25 * ($this->MISS * 0.9731 - 0.02)**13;
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
                                            $this->exploit_code_matury * $this->remediation_level * $this->report_confidence   
                                        );
                }else{
                    $this->EnvironmentalScore = roundUp(
                        roundUp(
                            min(1.08 * ($this->ModifiedImpact  + $this->ModifiedExploitability), 10)
                            ) *
                        $this->exploit_code_matury * $this->remediation_level * $this->report_confidence   
                    );
                }
            }
            
            $this->severity_env = ratingScale($this->EnvironmentalScore);
        }
       
    }

    public function GenerateVectorString($tab)
    {
        $vector = "CVSS:3.1";

        foreach ($tab as $key => $value) {
            $vector = $vector . "/" . $key . ":" . $value; 
        }

        return $vector;
    }

    public function UpdateVectorString($id, $tab, $lettre)
    {
        //si on n'appuie pas su le bouton NOT DEFINED
        if($lettre != "X"){
            $this->vector_string_tab[$id] = $lettre;
        }else{
            unset($this->vector_string_tab[$id]);
        }
    }
    

    public function render()
    {
        return view('livewire.calculate');
    }
}

