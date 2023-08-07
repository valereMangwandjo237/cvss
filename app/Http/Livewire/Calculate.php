<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Calculate extends Component
{
    /* METRIQUE 

            DE

        BASE
    */
    protected $base_verified = [];
    public $ISS = 16;
    public $impact = 0;
    public $exploitability = 0;
    public float $base_score = 0;
    public string $severity_base = "";
    public string $css_severity_base = "";


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

    public function mount()
    {
        $this->base_verified = [];
    }

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
        "Privileges Required (PR)" => [
            "id" => "base_PR",
            "None (N)" => 0.85,
            "Low (L)" => 0.62, //(0.68 if Scope / Modified Scope is Changed)
            "High (H)" => 0.27 //(0.50 if Scope / Modified Scope is Changed)
        ],
        "User Interaction (UI)" => [
            "id" => "base_UI",
            "None (N)" => 0.85,
            "Required (R)" => 0.62
        ],
        "Confidentiality (C)" => [
            "id" => "base_C",
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "Integrity (I)" => [
            "id" => "base_I",
            "None (N)" => 0,
            "Low (L)" => 0.22,
            "High (H)" => 0.56
        ],
        "Availability (A)" => [
            "id" => "base_A",
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
            default:
                echo "error";
        }
        
        
    }

    /*cette fonction permet de didentifer tous les elements choisis sur la 
    calculatrice, afin deffectuer un calcul quand tous les elements seront selectionnés*/
    public function select_case($element){
        if (!in_array($element, $this->base_verified)) {
            $this->base_verified[] = $element;
        }
        $this->calculate_base_score();
        //dump($this->base_verified);

        /*if(count($this->base_verified) == 8){
            $this->calculate_base_score();
        }*/
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
                $this->base_score = $this->round_up(min(($this->impact + $this->exploitability), 10));
            }else{
                $this->base_score = $this->round_up(min(1.08 * ($this->impact  + $this->exploitability), 10));
            }
        }

        $this->rating_scale($this->base_score);
    }

    public function rating_scale(float $score)
    {
        if($score == 0.0){
            $this->severity_base =  "None";
            $this->css_severity_base =  "success";
        }
        if($score > 0.0 && $score < 4.0){
            $this->severity_base =  "Low";
            $this->css_severity_base =  "warning";
        }
        if($score > 3.9 && $score < 7.0){
            $this->severity_base =  "Medium";
            $this->css_severity_base =  "warning";
        }
        if($score > 6.9 && $score < 9.0){
            $this->severity_base =  "High";
            $this->css_severity_base =  "danger";
        }
        if($score > 8.9 && $score < 10.1){
            $this->severity_base =  "Critical";
            $this->css_severity_base =  "danger";
        }

       // return $this->severity_base;
    }

    
    public function round_up(float $number): float
    {
        $intInput = round($number * 100000);
        return $intInput % 10000 === 0 ? $intInput / 100000.0 : (floor($intInput / 10000) + 1) / 10.0;
    }

    public function render()
    {
        return view('livewire.calculate');
    }
}
