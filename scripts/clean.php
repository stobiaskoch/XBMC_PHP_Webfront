<?php 
$host = "a:a@192.168.2.11"; //Adresse auf dem XBMC läuft 

//Ab hier nichts mehr verändern 
$object = IPS_GetObject($IPS_SELF); 
$parentID = $object['ParentID']; 

//Installieren 
if ($_IPS['SENDER'] == "Execute") 
{ 
    //Sicht selbst verstecken 
    IPS_SetHidden($_IPS['SELF'], true); 
     
    //Namen ändern 
    IPS_SetName($_IPS['SELF'], "Datenempfang"); 

    //Variablenprofile erstellen 
    $profile = @IPS_GetVariableProfile("XBMC_PlayState"); 
    if ($profile === false) 
    { 
        IPS_CreateVariableProfile("XBMC_PlayState", 1); 
        IPS_SetVariableProfileValues("XBMC_PlayState", 0, 4, 0); 
        IPS_SetVariableProfileIcon("XBMC_PlayState", "ArrowRight"); 
        IPS_SetVariableProfileAssociation("XBMC_PlayState", 0, "Play", "", -1); 
        IPS_SetVariableProfileAssociation("XBMC_PlayState", 1, "Pause", "", -1); 
        IPS_SetVariableProfileAssociation("XBMC_PlayState", 2, "Stop", "", -1); 
    } 

    $profile = @IPS_GetVariableProfile("XBMC_Position"); 
    if ($profile === false) 
    { 
        IPS_CreateVariableProfile("XBMC_Position", 1); 
        IPS_SetVariableProfileValues("XBMC_Position", 0, 100, 1); 
        IPS_SetVariableProfileIcon("XBMC_Position", "Gauge"); 
        IPS_SetVariableProfileText("XBMC_Position", "", " %"); 
    } 

    //Dummy Instanz erstellen 
    $parentObject = IPS_GetObject($parentID); 
    if ($parentObject['ObjectType'] !== 1) 
    { 
        $instanceID = IPS_CreateInstance("{485D0419-BE97-4548-AA9C-C083EB82E61E}"); 
        IPS_SetParent($instanceID, $parentID); 
        $parentID = $instanceID; 
        IPS_SetParent($_IPS['SELF'], $parentID); 
        IPS_SetName($instanceID, "XBMC"); 
    } 

    //Variablen erstellen 
    $titleID = CreateVariableByIdent($parentID, "Title", "Titel", 3, "~String", 0); 
    $positionID = CreateVariableByIdent($parentID, "Position", "Position", 3, "", 0); 
    $statusID = CreateVariableByIdent($parentID, "Status", "Status", 1, "XBMC_PlayState", $_IPS['SELF']); 
    $seekID = CreateVariableByIdent($parentID, "Seek", "Suchen", 1, "XBMC_Position", $_IPS['SELF']); 

    //Variablen Positionieren 
    IPS_SetPosition($titleID, 1); 
    IPS_SetPosition($positionID, 2); 
    IPS_SetPosition($statusID, 3); 
    IPS_SetPosition($seekID, 4); 

    //Variablen auf Default stellen 
    SetValue($titleID, "-"); 
    SetValue($positionID, ""); 
    SetValue($statusID, 3); 
    SetValue($seekID, 0); 

    //Instanzen erstellen 
    $socketID = @IPS_GetInstanceIDByName("XBMC Socket", 0); 
    if ($socketID === false) 
    { 
        $socketID = IPS_CreateInstance("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}"); 
        IPS_SetName($socketID, "XBMC Socket"); 
    } 
    CSCK_SetHost($socketID, $host); 
    CSCK_SetPort($socketID, 9090); 
    CSCK_SetOpen($socketID, true); 
    IPS_ApplyChanges($socketID); 

    $rvID = @IPS_GetInstanceIDByName("XBMC Data", $parentID); 
    if ($rvID === false) 
    { 
        $rvID = IPS_CreateInstance("{F3855B3C-7CD6-47CA-97AB-E66D346C037F}"); 
        IPS_SetParent($rvID, $parentID); 
        IPS_SetName($rvID, "XBMC Data"); 
    } 
    RegVar_SetRXObjectID($rvID, $_IPS['SELF']); 
    IPS_ConnectInstance($rvID, $socketID); 
    IPS_ApplyChanges($rvID); 
    IPS_SetHidden($rvID, true); 

    //ScriptTimer erstellen 
    IPS_SetScriptTimer($_IPS['SELF'], 0); 
} 
else if ($_IPS['SENDER'] == "RegisterVariable") 
{ 
    $statusID = GetVariableByIdent("Status", $parentID); 
    $titleID = GetVariableByIdent("Title", $parentID); 
    $seekID = GetVariableByIdent("Seek", $parentID); 
    $positionID = GetVariableByIdent("Position", $parentID); 

    $response = json_decode($_IPS['VALUE']); 
    if(isset($response->result)) 
    { 
        $result = $response->result; 
        if(isset($result->percentage)) 
           SetValue($seekID, $result->percentage); 
        if(isset($result->totaltime)) 
        { 
            if(isset($result->time)) 
            { 
               $time = sprintf("%02d:%02d:%02d", $result->time->hours, $result->time->minutes, $result->time->seconds); 
               $totaltime = sprintf("%02d:%02d:%02d", $result->totaltime->hours, $result->totaltime->minutes, $result->totaltime->seconds); 
                SetValue($positionID, $time." / ".$totaltime); 
            } 
        } 
        if(isset($result->item)) 
            if(isset($result->item->label)) 
                SetValue($titleID, $result->item->label); 
    } 
    if(isset($response->method)) 
    { 
        switch($response->method) 
        { 
            case "Player.OnPause": 
                SetValue($statusID, 1); 
                IPS_SetScriptTimer($_IPS['SELF'], 0); 
                break; 
            case "Player.OnPlay": 
                SetValue($statusID, 0); 
                IPS_SetScriptTimer($_IPS['SELF'], 5); 
                    SendCommand("Player.GetItem", Array("playerid" => 1)); 
                break; 
            case "Player.OnSeek": 
                break; 
            case "Player.OnStop": 
                SetValue($titleID, "-"); 
                SetValue($positionID, "00:00 / 00:00"); 
                SetValue($statusID, 2); 
                SetValue($seekID, 0); 
                IPS_SetScriptTimer($_IPS['SELF'], 0); 
                break; 
        } 
    } 
} 
else if ($_IPS['SENDER'] == "WebFront") 
{ 
    $statusID = GetVariableByIdent("Status", $parentID); 
    $seekID = GetVariableByIdent("Seek", $parentID); 

    switch ($_IPS['VARIABLE']) 
    { 
        case $statusID: 
           switch($_IPS['VALUE']) 
           { 
              case 0: 
                 SendCommand("Player.PlayPause", Array("playerid" => 1)); 
                 break; 
              case 1: 
                 SendCommand("Player.PlayPause", Array("playerid" => 1)); 
                 break; 
              case 2: 
                 SendCommand("Player.Stop", Array("playerid" => 1)); 
                 break; 
           } 
            break; 
        case $seekID: 
         SendCommand("Player.Seek", Array("playerid" => 1, "value"=>$_IPS['VALUE'])); 
            break; 
    } 
} 
else if ($_IPS['SENDER'] == "TimerEvent") 
{ 
   SendCommand("Player.GetProperties", Array("playerid" => 1, "properties"=>Array('time', 'totaltime', 'percentage'))); 
} 

function CreateVariableByIdent($id, $ident, $name, $type, $profile, $action) 
 { 
     $vid = @IPS_GetObjectIDByIdent($ident, $id); 
     if($vid === false) 
     { 
         $vid = IPS_CreateVariable($type); 
         IPS_SetParent($vid, $id); 
         IPS_SetName($vid, $name); 
         IPS_SetIdent($vid, $ident); 
         IPS_SetInfo($vid, "this variable was created by script #".$_IPS['SELF']); 
         IPS_SetVariableCustomProfile($vid, $profile); 
            IPS_SetVariableCustomAction($vid, $action); 
     } 
     return $vid; 
} 

function GetVariableByIdent($ident, $id) 
 { 
     $vid = @IPS_GetObjectIDByIdent($ident, $id); 
     if($vid === false) 
     { 
         die("Kann Variable nicht finden"); 
     } 
     return $vid; 
} 

function SendCommand($method, $params) 
{ 
    global $parentID; 
    $rvID = @IPS_GetInstanceIDByName("XBMC Data", $parentID); 
    RegVar_SendText($rvID, '{"jsonrpc":"2.0", "method":"'.$method.'", "params":'.json_encode($params).', "id" : 1}'); 
} 


?>