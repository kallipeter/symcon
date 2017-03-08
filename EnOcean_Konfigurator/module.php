<?
$max_shutter = 21;
// Klassendefinition
class EnOcean_Konfigurator extends IPSModule {
	public function Create()
	{
		//Never delete this line!
		parent::Create();
		$this->RegisterPropertyString("Eltako_FAM_ID", "FF1234");
		$this->RegisterPropertyInteger("Shutter_StartID", 40);
		$i = 1;
		global $max_shutter;
		while ($i <= $max_shutter)
		{
			$this->RegisterPropertyString("Floor_".$i, "false");
			$this->RegisterPropertyString("Roomname_".$i, "Raumname");
			$this->RegisterPropertyString("Location_".$i, "Position");
			$i = $i+1;
			//echo $i;
		}
	}

	// Überschreibt die intere IPS_ApplyChanges($id) Funktion
	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
	}
	public function CreateModules() {
		$CatEnOceanID = @IPS_GetCategoryIDByName("EnOcean", 0);
		if ($CatEnOceanID === false) {
			$CatEnOceanID = IPS_CreateCategory();       // Kategorie anlegen
			IPS_SetName($CatEnOceanID, "EnOcean"); // Kategorie benennen
			IPS_SetParent($CatEnOceanID, 0); // Kategorie einsortieren unter dem Objekt mit der ID "0"
		}
		$CatShutterID = @IPS_GetCategoryIDByName("Beschattung", $CatEnOceanID);
		if ($CatShutterID === false) {
			$CatShutterID = IPS_CreateCategory();       // Kategorie anlegen
			IPS_SetName($CatShutterID, "Beschattung"); // Kategorie benennen
			IPS_SetParent($CatShutterID, $CatEnOceanID); // Kategorie einsortieren unter dem Objekt "EnOcean"
		}
		
		// Gloabale Werte
		$Eltako_FAM_ID = $this->ReadPropertyString("Eltako_FAM_ID");
		$Shutter_StartID = $this->ReadPropertyInteger("Shutter_StartID");
		
		// Jalousie Nr.1
		// Nummern anpassen
		$JalNumber = 1;
		// Nichts mehr anpassen
		//global $max_shutter;
		echo "create";
		while ($JalNumber <= 21)
		{
			$DeviceID = $Shutter_StartID+$JalNumber-1;
			$Floor = $this->ReadPropertyString("Floor_".$JalNumber);
			$Roomname = $this->ReadPropertyString("Roomname_".$JalNumber);
			$Location = $this->ReadPropertyString("Location_".$JalNumber);
			$Position = $Floor."/".$Roomname."/".$Location;
			if ($Floor != "false") {
				$InsShutterID = IPS_CreateInstance("{1463CAE7-C7D5-4623-8539-DD7ADA6E92A9}");
				IPS_SetName($InsShutterID, $Position); // Instanz benennen
				IPS_SetInfo($InsShutterID, "Test");
				IPS_SetPosition($InsShutterID, $DeviceID);
				IPS_SetParent($InsShutterID, $CatShutterID);
				$control_ID = hexdec($Eltako_FAM_ID);
				$control_ID = $control_ID+$Shutter_StartID+$JalNumber-1;
				$ReturnID = dechex($control_ID);
				IPS_SetConfiguration($InsShutterID, '{"DeviceID":'.$DeviceID.',"ReturnID":"'.$ReturnID.'","ButtonMode":1,"EmulateStatus":false}');
				IPS_ApplyChanges($InsShutterID);
			}
			$JalNumber = $JalNumber+1;
		}
	}
 }
?>
