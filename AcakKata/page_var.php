<?php
	/*
	 * page_var.php
	 * is intended to store any functions and variables
	 * related with connecting controller and views
	 * 
	 */	

	/*
	 * store any variables which set by setvar
	 */
	$EXPORT = array();
	
	/*
	 * retrieve variable which set by setvar()
	 */
	function getvar($var, $wrap=false) {
		global $EXPORT;
		if (!isset($EXPORT[$var])) {
			echo "null";
		} else {
			if (gettype($EXPORT[$var]) == "array") {
				echo json_encode($EXPORT[$var]);
			} else if (gettype($EXPORT[$var]) == "string") {
				if ($wrap) {
                    echo "'".$EXPORT[$var]."'";
				} else {
					echo $EXPORT[$var]; 
				}
			} else {
				echo $EXPORT[$var];
			}
		}
	}

	/*
	 * set any variables needed to get by getvar
	 */
	function setvar($var, $value) {
		global $EXPORT;
		$EXPORT[$var] = $value;
	}

	/*
	 * embed content of file with given name in parameter,
	 * embedded file should be located in /views/addons
	 */
	function embed($filename) {
		include "views/addons/".$filename.".php";
	}
?>