<?php
function clean_submissions(){
	system("rm -rf ../submissions/*");
}

$act = $_GET["act"];
switch ($act) 
{ 
	case "cque": 
    	clean_submissions();
    	break;
    case "spm":
        system("./setperm.sh");
        break;
    case "upm":
        system("./unperm.sh");
        break;
	default: 
    	break; 
} 
echo "Done.";
?>