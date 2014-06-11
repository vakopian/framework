<template OverwriteFlag="true" DocrootFlag="false" DirectorySuffix="" TargetDirectory="<?php echo __META_CONTROLS_GEN__ ?>" TargetFileName="<?php echo $objTable->ClassName ?>ViewWithRelationshipsGen.class.php"/>
<?php
	/** @var QTable $objTable */
	/** @var QDatabaseCodeGen $this */
?>
<?php print("<?php\n"); ?>
	require_once(__META_CONTROLS__ . '/<?php echo $objTable->ClassName ?>ViewWithToolbar.class.php');
<?php
	/** @var array $objReferenceArray */
	$objReferenceArray = array();
	/** @var QReverseReference[] $objCollectionsArray */
	$objCollectionsArray = array();

	if ($objTable->ColumnArray) foreach ($objTable->ColumnArray as $objColumn) {
		if ($objColumn->Reference && !$objColumn->Reference->IsType) {
			$objReferenceArray[$objColumn->Reference->PropertyName] = $objColumn->Reference;
		}
	}
	if ($objTable->ReverseReferenceArray) foreach ($objTable->ReverseReferenceArray as $objReference) {
		if ($objReference->Unique) {
			$objReferenceArray[$objReference->ObjectPropertyName] = $objReference;
		} else {
			$objReferencedTable = $this->GetTable($objReference->Table);
			$strPropertyName = $objReference->ObjectDescription;
			if (strpos($strPropertyName, $objReferencedTable->ClassName.'As') === 0) {
				$strPropertyName = substr($strPropertyName, strlen($objReferencedTable->ClassName) + 2);
			}
			$strPropertyName = $this->Pluralize($strPropertyName);

			$objCollectionsArray[$strPropertyName] = $objReference;
		}
	}
?>
<?php
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
		/** @var QReference|QReverseReference $objReference */
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
	require_once(__META_CONTROLS__ . '/<?php echo $objReferencedTable->ClassName ?>ViewWithToolbar.class.php');
<?php
	}
?>

<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
	require_once(__META_CONTROLS__ . '/<?php echo $objReferencedTable->ClassName ?>CollectionPanel.class.php');
<?php
	}
?>

	/**
	 * @property-read <?php echo $objTable->ClassName ?>Toolbar $Toolbar
	 * @property-read QControl $Container
	 * @property-read <?php echo $objTable->ClassName ?>ViewWithToolbar $MainView
	 * @property-read <?php echo $objTable->ClassName ?>ViewWithToolbar $<?php echo $objTable->ClassName ?>View
<?php
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
		/** @var QReference|QReverseReference $objReference */
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
	 * @property-read <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar $<?php echo $strPropertyName ?>View
<?php
	}
?>
<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
	 * @property-read <?php echo $objReferencedTable->ClassName ?>CollectionPanel $<?php echo $strPropertyName ?>Collection
<?php
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
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
		/** @var QReference|QReverseReference $objReference */
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/** @var <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar */
		protected $pnl<?php echo $strPropertyName ?>View;
<?php
	}
?>
<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/** @var <?php echo $objReferencedTable->ClassName ?>CollectionPanel */
		protected $pnl<?php echo $strPropertyName ?>Collection;
<?php
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
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
		/** @var QReference|QReverseReference $objReference */
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
			$this->add<?php echo $strPropertyName ?>Control($obj<?php echo $objTable->ClassName ?>);
<?php
	}
?>
<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
			$this->add<?php echo $strPropertyName ?>CollectionControl($obj<?php echo $objTable->ClassName ?>);
<?php
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
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
		/** @var QReference|QReverseReference $objReference */
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/**
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 */
		protected function add<?php echo $strPropertyName ?>Control($obj<?php echo $objTable->ClassName ?>) {
			if ($obj<?php echo $objTable->ClassName ?> && $obj<?php echo $objTable->ClassName ?>-><?php echo $strPropertyName ?> && $obj<?php echo $objTable->ClassName ?>-><?php echo $strPropertyName ?>->__Restored) {
				$this->pnl<?php echo $strPropertyName ?>View = new <?php echo $objReferencedTable->ClassName ?>ViewWithToolbar($this->ctlContainer, $obj<?php echo $objTable->ClassName ?>-><?php echo $strPropertyName ?>, false, true, false, false);
				$this->strSubControlNames[] = '<?php echo $strPropertyName ?>';
			}
		}
<?php
	}
?>
<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
		$objReferencedTable = $this->GetTable($objReference->Table);
?>
		/**
		 * @param <?php echo $objTable->ClassName  ?> $obj<?php echo $objTable->ClassName ?>

		 */
		protected function add<?php echo $strPropertyName ?>CollectionControl($obj<?php echo $objTable->ClassName ?>) {
			if ($obj<?php echo $objTable->ClassName ?>) {
				$collection = $obj<?php echo $objTable->ClassName ?>->Get<?php echo $objReference->ObjectDescription ?>Array();
				$this->pnl<?php echo $strPropertyName ?>Collection = new <?php echo $objReferencedTable->ClassName ?>CollectionPanel($this->ctlContainer, $collection, false, true, false, false);
				$this->strSubControlNames[] = '<?php echo $strPropertyName ?>';
			}
		}
<?php
	}
?>

		public function __get($strName) {
			switch ($strName) {
				case "Toolbar": return $this->pnlMainView->Toolbar;
				case "Container": return $this->ctlContainer;
				case "MainView":
				case "<?php echo $objTable->ClassName ?>View": return $this->pnlMainView;
<?php
	foreach ($objReferenceArray as $strPropertyName => $objReference) {
?>
				case "<?php echo $strPropertyName ?>View": return $this->pnl<?php echo $strPropertyName ?>View;
<?php
	}
?>
<?php
	foreach ($objCollectionsArray as $strPropertyName => $objReference) {
?>
				case "<?php echo $strPropertyName ?>Collection": return $this->pnl<?php echo $strPropertyName ?>Collection;
<?php
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
