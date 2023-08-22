<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public $base = [
        "Attack Vector (AV)" => [
            "id" => "base_AV",
            "Network (N)" => 23,
            "Adjacent (A)" => 13,
            "Local (L)" => 10,
            "Physical (P)" => 45
        ],
        "Attack Complexity (AC)" => [
            "id" => "base_AC",
            "Low (L)" => 23,
            "High (H)" => 23
        ],
        "Scope (S)" => [
            "id" => "base_S",
            "Unchanged (S)" => 23,
            "Changed (C)" => 23
        ],
        "Privileges Required (PR)" => [
            "id" => "base_PR",
            "None (N)" => 23,
            "Low (L)" => 23,
            "High (H)" => 23
        ],
        "User Interaction (UI)" => [
            "id" => "base_UI",
            "None (N)" => 23,
            "Required (R)" => 23
        ],
        "Confidentiality (C)" => [
            "id" => "base_C",
            "None (N)" => 23,
            "Low (L)" => 23,
            "High (H)" => 23
        ],
        "Integrity (I)" => [
            "id" => "base_I",
            "None (N)" => 23,
            "Low (L)" => 23,
            "High (H)" => 23
        ],
        "Availability (A)" => [
            "id" => "base_A",
            "None (N)" => 23,
            "Low (L)" => 23,
            "High (H)" => 23
        ],
    ];

    public $environmental  = [
        "Confidentiality Requirement (CR)" => [
            "id" => "env_CR",
            "Not Defined (X)" => 23,
            "Low (L)" => 23,
            "Medium (M)" => 23,
            "High (H)" => 23,
        ],
        "Integrity Requirement (IR)" => [
            "id" => "env_IR",
            "Not Defined (X)" => 23,
            "Low (L)" => 23,
            "Medium (M)" => 23,
            "High (H)" => 23,
        ],
        "Availability Requirement (AR)" => [
            "id" => "env_AR",
            "Not Defined (X)" => 23,
            "Low (L)" => 23,
            "Medium (M)" => 23,
            "High (H)" => 23,
        ],
        "Modified Attack Vector (MAV)" => [
            "id" => "env_MAV",
            "Not Defined (X)" => 23,
            "Network" => 23,
            "Adjacent Network" => 23,
            "Local" => 23,
            "Physical" => 23,
        ],
        "Modified Attack Complexity (MAC)" => [
            "id" => "env_MAC",
            "Not Defined (X)" => 23,
            "Low" => 23,
            "High" => 23,
        ],
        "Modified Privileges Required (MPR)" => [
            "id" => "env_MPR",
            "Not Defined (X)" => 23,
            "None" => 23,
            "Low" => 23,
            "High" => 23
        ],
        "Modified User Interaction (MUI)" => [
            "id" => "env_MUI",
            "Not Defined (X)" => 23,
            "None" => 23,
            "Required" => 23
        ],
        "Modified Scope (MS)" => [
            "id" => "env_MS",
            "Not Defined (X)" => 23,
            "None (N)" => 23,
            "Unchanged" => 23,
            "Changed" => 23
        ],
        "Modified Confidentiality (MC)" => [
            "id" => "env_MC",
            "Not Defined (X)" => 23,
            "None" => 23,
            "Low" => 23,
            "High" => 23
        ],
        "Modified Integrity (MI)" => [
            "id" => "env_MI",
            "Not Defined (X)" => 23,
            "None" => 23,
            "Low" => 23,
            "High" => 23
        ],
        "Modified Availability (MA)" => [
            "id" => "env_MA",
            "Not Defined (X)" => 23,
            "None" => 23,
            "Low" => 23,
            "High" => 23
        ],
    ];

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

    public function index()
    {
        session()->forget('base');

        return view("index");
    }








   /* var Weight = {
        AV: {
            N: 0.85,
            A: 0.62,
            L: 0.55,
            P: 0.2
        },
        AC: {
            H: 0.44,
            L: 0.77
        },
        PR: {
            U: {
                N: 0.85,
                L: 0.62,
                H: 0.27
            },
            // These values are used if Scope is Unchanged
            C: {
                N: 0.85,
                L: 0.68,
                H: 0.5
            }
        },
        // These values are used if Scope is Changed
        UI: {
            N: 0.85,
            R: 0.62
        },
        S: {
            U: 6.42,
            C: 7.52
        },
        C: {
            N: 0,
            L: 0.22,
            H: 0.56
        },
        I: {
            N: 0,
            L: 0.22,
            H: 0.56
        },
        A: {
            N: 0,
            L: 0.22,
            H: 0.56
        }
        // C, I and A have the same weights

    }*/
}
