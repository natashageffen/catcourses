<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$_POST["radTrail"]="bob's";

$pmkTrailsId = (int) htmlentities($_POST["radTrail"], ENT_QUOTES, "UTF-8");
    print '<p>trail id=' . $pmkTrailsId;