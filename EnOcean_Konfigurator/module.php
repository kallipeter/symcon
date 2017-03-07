<?
// Klassendefinition
class EnOcean_Konfigurator extends IPSModule {
	public function Create()
	{
		//Never delete this line!
		parent::Create();
		
		$this->RegisterPropertyString("Eltako_FAM_ID", "000000");
		$this->RegisterPropertyInteger("Shutter_StartID", 40);
		$this->RegisterPropertyBoolean("create", true);
		$this->RegisterPropertyString("Floor", "EG");
		$this->RegisterPropertyString("Roomname", "Küche");
		$this->RegisterPropertyString("Location", "links");
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
		
		$InsShutterID = IPS_CreateInstance("{1463CAE7-C7D5-4623-8539-DD7ADA6E92A9}");
		$Eltako_FAM_ID = $this->ReadPropertyString("Eltako_FAM_ID");
		$Shutter_StartID = $this->ReadPropertyInteger("Shutter_StartID");
		$create = $this->ReadPropertyString("create");
		$Floor = $this->ReadPropertyString("Floor");
		$Roomname = $this->ReadPropertyString("Roomname");
		$Location = $this->ReadPropertyString("Location");
		$Position = $Floor."/".$Roomname."/".$Location;
		IPS_SetName($InsShutterID, $Position); // Instanz benennen
		IPS_SetInfo($InsShutterID, "Test");
		IPS_SetPosition($InsShutterID, $Shutter_StartID);
		IPS_SetParent($InsShutterID, $CatShutterID);
			//$Roomname = $this->ReadPropertyString("Roomname");
			//IPS_SetConfiguration($InsShutterID, '{"DeviceID":$this->ReadPropertyInteger("Shutter_StartID"),"ReturnID":$this->ReadPropertyString("Eltako_FAM_ID"),"ButtonMode":1,"EmulateStatus":false}');
		//$Shutter_StartID = 40;
		//$Eltako_FAM_ID ="FFAA12";
		$control_ID = hexdec($Eltako_FAM_ID);
		$control_ID = $control_ID+$Shutter_StartID;
		$ReturnID = dechex($control_ID);
		IPS_SetConfiguration($InsShutterID, '{"DeviceID":'.$Shutter_StartID.',"ReturnID":"'.$ReturnID.'","ButtonMode":1,"EmulateStatus":false}');
		IPS_ApplyChanges($InsShutterID);
	}
	
 }
?>
