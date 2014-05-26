<template OverwriteFlag="true" DocrootFlag="false" DirectorySuffix="" TargetDirectory="<?php echo __META_CONTROLS_GEN__ ?>" TargetFileName="<?php echo $objTable->ClassName ?>ViewWithRelationshipsGen.class.php"/>
<?php print("<?php\n"); ?>
	require_once(__META_CONTROLS__ . '/<?php echo $objTable->ClassName ?>ViewWithToolbar.class.php');
<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
	require_once(__META_CONTROLS__ . '/<?php echo $objReferencedTable->ClassName ?>ViewWithToolbar.class.php');
<?php
		}
	}
?>

	/**
	 * @property-read <?php echo $objTable->ClassName ?>Toolbar $Toolbar
	 * @property-read QControl $Container
	 * @property-read <?php echo $objTable->ClassName ?>ViewWithToolbar $MainView
	 * @property-read <?php echo $objTable->ClassName ?>ViewWithToolbar $<?php echo $objTable->ClassName ?>View
<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
	 * @property-read <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar $<?php echo $objReference->PropertyName ?>View
<?php
		}
	}
?>
	 */
	class <?php echo $objTable->ClassName ?>ViewWithRelationshipsGen extends QPanel {
		/** @var <?php echo $objTable->ClassName ?>ViewWithToolbar */
		protected $pnlMainView;
		/** @var QControl */
		protected $ctlContainer;
		/** @var string[] */
		protected $strSubControlNames;
<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/** @var <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar */
		protected $pnl<?php echo $objReference->PropertyName ?>View;
<?php
		}
	}
?>

		/**
		 * @param QControl|QForm $objParentObject
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 * @param string $strControlId
		 * @throws QCallerException
		 */
		public function __construct($objParentObject, $obj<?php echo $objTable->ClassName ?> = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			$this->AutoRenderChildren = true;
			$this->CssClass = '<?php echo QConvertNotation::UnderscoreFromCamelCase($objTable->ClassName) ?>_view_with_relationships view_with_relationships';
			$this->Reload($obj<?php echo $objTable->ClassName ?>);
		}

		/**
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 */
		public function Reload($obj<?php echo $objTable->ClassName ?> = null) {
			if ($this->ctlContainer) {
				$this->RemoveChildControl($this->ctlContainer->ControlId, true);
			} else {
				$this->ctlContainer = $this->createContainer();
			}
			$this->strSubControlNames = array();
			$this->add<?php echo $objTable->ClassName ?>Control($obj<?php echo $objTable->ClassName ?>);
			$mct<?php echo $objTable->ClassName ?> = $this->pnlMainView->MetaControl;
			$obj<?php echo $objTable->ClassName ?> = $mct<?php echo $objTable->ClassName ?> ? $mct<?php echo $objTable->ClassName ?>-><?php echo $objTable->ClassName ?> : null;
			$this->addControlsForRelationships($obj<?php echo $objTable->ClassName ?>);
			$this->postProcessContainer();
		}

		/**
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 */
		protected function addControlsForRelationships($obj<?php echo $objTable->ClassName ?>) {
<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
			$this->add<?php echo $objColumn->Reference->PropertyName ?>Control($obj<?php echo $objTable->ClassName ?>);
<?php
		}
	}
?>
		}

		protected function postProcessContainer() {
			$headers = array();
			foreach ($this->strSubControlNames as $name) {
				$headers[] = QApplication::Translate($name);
			}
			/** @var QTabs $objTabs */
			$objTabs = QType::Cast($this->ctlContainer, 'QTabs');
			$objTabs->Headers = $headers;
		}

		protected function createContainer() {
			return new QTabs($this);
		}

		protected function add<?php echo $objTable->ClassName ?>Control($obj<?php echo $objTable->ClassName ?>) {
			$this->pnlMainView = new <?php echo $objTable->ClassName ?>ViewWithToolbar($this->ctlContainer, $obj<?php echo $objTable->ClassName ?>, true, true, true, false);
			$this->strSubControlNames[] = '<?php echo $objTable->ClassName ?>';
		}

<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/**
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 */
		protected function add<?php echo $objColumn->Reference->PropertyName ?>Control($obj<?php echo $objTable->ClassName ?>) {
			if ($obj<?php echo $objTable->ClassName ?> && $obj<?php echo $objTable->ClassName ?>-><?php echo $objColumn->Reference->PropertyName ?> && $obj<?php echo $objTable->ClassName ?>-><?php echo $objColumn->Reference->PropertyName ?>->__Restored) {
				$this->pnl<?php echo $objReference->PropertyName ?>View = new <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar($this->ctlContainer, $obj<?php echo $objTable->ClassName ?>-><?php echo $objColumn->Reference->PropertyName ?>, false, true, false, false);
				$this->strSubControlNames[] = '<?php echo $objReference->PropertyName ?>';
			}
		}
<?php
		}
	}
?>

		public function __get($strName) {
			switch ($strName) {
				case "Toolbar": return $this->pnlMainView->Toolbar;
				case "Container": return $this->ctlContainer;
				case "MainView":
				case "<?php echo $objTable->ClassName ?>View": return $this->pnlMainView;
<?php
	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReference = $objColumn->Reference;
			$objReferencedTable = $this->GetTable($objReference->Table);
?>
				case "<?php echo $objReference->PropertyName ?>View": return $this->pnl<?php echo $objReference->PropertyName ?>View;
<?php
		}
	}
?>

				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}
