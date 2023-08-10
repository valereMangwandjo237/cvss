<?php
  
if (!function_exists('ratingScale'))
{
  function ratingScale(float $score)
  {
    $tab = [];
      if($score == 0.0)
      {
          $tab[0] =  "None";
          $tab[1] =  "success";
      }
      if($score > 0.0 && $score < 4.0)
      {
          $tab[0] =  "Low";
          $tab[1] =  "warning";
      }
      if($score > 3.9 && $score < 7.0)
      {
          $tab[0] =  "Medium";
          $tab[1] =  "warning";
      }
      if($score > 6.9 && $score < 9.0)
      {
          $tab[0] =  "High";
          $tab[1] =  "danger";
      }
      if($score > 8.9 && $score < 10.1)
      {
          $tab[0] =  "Critical";
          $tab[1] =  "danger";
      }

      return $tab;
  }
}  

 
if (!function_exists("roundUp")) 
{
  function roundUp(float $number): float
  {
      $intInput = round($number * 100000);
      return $intInput % 10000 === 0 ? $intInput / 100000.0 : (floor($intInput / 10000) + 1) / 10.0;
  }
}
  