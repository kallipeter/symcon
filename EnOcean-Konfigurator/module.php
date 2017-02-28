<?
// Klassendefinition
class EnOcean extends IPSModule {
	public function Create() {
		// Diese Zeile nicht löschen.
		parent::Create();

		//$config = IPS_GetConfiguration($InsID);
		//echo $config;
}
	// Überschreibt die intere IPS_ApplyChanges($id) Funktion
	public function ApplyChanges() {
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
				// Anlegen einer neuen Kategorie mit dem namen "EnOcean"
		$CatEnOceanID = IPS_CreateCategory();       // Kategorie anlegen
		IPS_SetName($CatEnOceanID, "DEMO_EnOcean"); // Kategorie benennen
		IPS_SetParent($CatEnOceanID, 0); // Kategorie einsortieren unter dem Objekt mit der ID "0"
		$CatShutterID = IPS_CreateCategory();       // Kategorie anlegen
		IPS_SetName($CatShutterID, "DEMO_Beschattung"); // Kategorie benennen
		IPS_SetParent($CatShutterID, $CatEnOceanID); // Kategorie einsortieren unter dem Objekt "EnOcean"
		
		$InsShutterID = IPS_CreateInstance("{1463CAE7-C7D5-4623-8539-DD7ADA6E92A9}");
		IPS_SetName($InsShutterID, $this->ReadPropertyBoolean("Roomname")); // Instanz benennen
		IPS_SetInfo($InsShutterID, "Test");
		IPS_SetPosition($InsShutterID, 1);
		IPS_SetParent($InsShutterID, $CatShutterID);

		IPS_SetConfiguration($InsShutterID, '{"DeviceID":40,"ReturnID":"FFCAD6B2","ButtonMode":1,"EmulateStatus":false}');
		IPS_ApplyChanges($InsShutterID); //Neue Konfiguration übernehmen
    #######################
	}
	
 }
?>
