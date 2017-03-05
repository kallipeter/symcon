<?
// Klassendefinition
class EnOcean_Konfigurator extends IPSModule {
	public function Create()
	{
		//Never delete this line!
		parent::Create();
		
		$this->RegisterPropertyString("Eltako_FAM_ID", "000000");
		$this->RegisterPropertyInteger("Shutter_StartID", 40);
		$this->RegisterPropertyString("Floor", "EG");
		$this->RegisterPropertyString("Roomname", "Küche");
		$this->RegisterPropertyString("Location", "links");
	}
}
	// Überschreibt die intere IPS_ApplyChanges($id) Funktion
	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
	}
	public function CreateModules() {
		// Anlegen einer neuen Kategorie mit dem namen "EnOcean"
		$CatEnOceanID = IPS_CreateCategory();       // Kategorie anlegen
		IPS_SetName($CatEnOceanID, "EnOcean"); // Kategorie benennen
		IPS_SetParent($CatEnOceanID, 0); // Kategorie einsortieren unter dem Objekt mit der ID "0"
		$CatShutterID = IPS_CreateCategory();       // Kategorie anlegen
		IPS_SetName($CatShutterID, "Beschattung"); // Kategorie benennen
		IPS_SetParent($CatShutterID, $CatEnOceanID); // Kategorie einsortieren unter dem Objekt "EnOcean"
		
		$InsShutterID = IPS_CreateInstance("{1463CAE7-C7D5-4623-8539-DD7ADA6E92A9}");
		IPS_SetName($InsShutterID, $this->ReadPropertyString("Roomname")); // Instanz benennen
		IPS_SetInfo($InsShutterID, "Test");
		IPS_SetPosition($InsShutterID, 1);
		IPS_SetParent($InsShutterID, $CatShutterID);

		IPS_SetConfiguration($InsShutterID, '{"DeviceID":$this->ReadPropertyString("Shutter_StartID"),"ReturnID":$this->ReadPropertyBoolean("Eltako_FAM_ID"),"ButtonMode":1,"EmulateStatus":false}');
		IPS_ApplyChanges($InsShutterID);
	}
	
 }
?>
