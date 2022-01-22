<?php

	function ID_MAKER($tablename, $idname){
		$id = "";
		$connect = mysqli_connect("localhost", "root", "", "shophdb");
		$select = "SELECT * FROM $tablename";
		$run = mysqli_query($connect, $select);
		$num = mysqli_num_rows($run);

		if($num==0){
			$id = 1;
		}
		elseif($num>=1){
			for($a=0;$a<$num;$a++){
				$data = mysqli_fetch_array($run);
				$tempid = $data[$idname];
				if($tempid-1==$a){
					$id = $a+2;
				}
				elseif($tempid-1!=$a){
					$id = $a+1;
					break;
				}
			}
		}
		return $id;
	}

	function ATTRIBUTE_EXTRACTOR($tablename, $input_attribute_col_name, $input_attribute_value, $wantedattribute){
		$attribute = "";
		$connect = mysqli_connect("localhost", "root", "", "shophdb");
		$select = "SELECT * FROM $tablename";
		$run = mysqli_query($connect, $select);
		$num = mysqli_num_rows($run);

		for($i=0;$i<$num;$i++){
			$data = mysqli_fetch_array($run);
			$tempattribute = $data[$input_attribute_col_name];
			if($tempattribute==$input_attribute_value){
				$attribute = $data[$wantedattribute];
				break;
			}
			else{
				$attribute = "";
			}
		}

		return $attribute;
	}


	function ATTRIBUTE_CHECKER($tablename, $input_attribute_col_name, $input_attribute_value){
		$attribute = "";
		$connect = mysqli_connect("localhost", "root", "", "shophdb");
		$select = "SELECT * FROM $tablename";
		$run = mysqli_query($connect, $select);
		$num = mysqli_num_rows($run);

		for($i=0;$i<$num;$i++){
			$data = mysqli_fetch_array($run);
			$tempattribute = $data[$input_attribute_col_name];
			if($tempattribute==$input_attribute_value){
				$attribute = $tempattribute;
				break;
			}
			else{
				$attribute = "";
			}
		}

		return $attribute;
	}

	function PASSWORD_CHECKER($tablename, $tableattribute1, $tableattribute2, $input_attribute){
		$attribute = "";
		$connect = mysqli_connect("localhost", "root", "", "shophdb");
		$select = "SELECT * FROM $tablename";
		$run = mysqli_query($connect, $select);
		$num = mysqli_num_rows($run);

		for($i=0;$i<$num;$i++){
			$data = mysqli_fetch_array($run);
			$tempattribute = $data[$tableattribute1];
			if($tempattribute==$input_attribute){
				$attribute = $data[$tableattribute2];
				break;
			}
			else{
				$attribute = "";
			}
		}

		return $attribute;
	}

	function PWSTRENGTH($input_attribute){
		$uppercase = preg_match('@[A-Z]@', $input_attribute);
		$lowercase = preg_match('@[a-z]@', $input_attribute);
		$number    = preg_match('@[0-9]@', $input_attribute);
		$specialChars = preg_match('@[^\w]@', $input_attribute);

		if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($input_attribute) < 8) {
    		return False;
		}
		else{
    		return True;
		}
	}

	function DELETE($tablename, $attribute){

	}

?>