<?
Class andead_changestatus extends CModule
{
	const MODULE_ID = "andead.changestatus";
	
	var $MODULE_ID = "andead.changestatus";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	function andead_changestatus()
	{
		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
			$this->MODULE_NAME = $arModuleVersion["MODULE_NAME"];
			$this->MODULE_DESCRIPTION = $arModuleVersion["MODULE_DESCRIPTION"];
		}
	}

	function InstallDB($arParams = array()) {
        return true;
    }

    function UnInstallDB($arParams = array()) {
        return true;
    }

    function InstallEvents() {
        return true;
    }

    function UnInstallEvents() {
        return true;
    }

    function InstallFiles($arParams = array()) {
        return true;
    }

    function UnInstallFiles() {

        return true;
    }

    function DoInstall() {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallDB();
        RegisterModule(self::MODULE_ID);
    }

    function DoUninstall() {
        global $APPLICATION;
        UnRegisterModule(self::MODULE_ID);
        $this->UnInstallDB();
        $this->UnInstallFiles();
    }
}
?>