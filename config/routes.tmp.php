<?php
$root = array();
$root["count"]=2;
$root[0]=array();
$root[0]["type"]="normal";
$root[0]["name"]="callback";
$root[0]["get"]["controller"]="callback";
$root[0]["get"]["action"]="index";
$root[0]["post"]["controller"]="callback";
$root[0]["post"]["action"]="create";
$root[0]["count"]=2;
$root[0][0]=array();
$root[0][0]["type"]="normal";
$root[0][0]["name"]="new";
$root[0][0]["get"]["controller"]="callback";
$root[0][0]["get"]["action"]="newa";
$root[0][0]["count"]=0;
$root[0][1]=array();
$root[0][1]["type"]="any";
$root[0][1]["name"]=array();
$root[0][1]["name"][0]="id";
$root[0][1]["name"][1]="id";
$root[0][1]["name"][2]="id";
$root[0][1]["name"][3]="id";
$root[0][1]["get"]["controller"]="callback";
$root[0][1]["get"]["action"]="show";
$root[0][1]["post"]["controller"]="callback";
$root[0][1]["post"]["action"]="update";
$root[0][1]["count"]=2;
$root[0][1][0]=array();
$root[0][1][0]["type"]="normal";
$root[0][1][0]["name"]="edit";
$root[0][1][0]["get"]["controller"]="callback";
$root[0][1][0]["get"]["action"]="edit";
$root[0][1][0]["count"]=0;
$root[0][1][1]=array();
$root[0][1][1]["type"]="normal";
$root[0][1][1]["name"]="delete";
$root[0][1][1]["post"]["controller"]="callback";
$root[0][1][1]["post"]["action"]="delete";
$root[0][1][1]["count"]=0;
$root[1]=array();
$root[1]["type"]="normal";
$root[1]["name"]="request";
$root[1]["count"]=1;
$root[1][0]=array();
$root[1][0]["type"]="normal";
$root[1][0]["name"]="twitter";
$root[1][0]["count"]=1;
$root[1][0][0]=array();
$root[1][0][0]["type"]="any";
$root[1][0][0]["name"]=array();
$root[1][0][0]["name"][0]="id";
$root[1][0][0]["both"]["controller"]="req";
$root[1][0][0]["both"]["action"]="twdo";
$root[1][0][0]["count"]=0;
?>