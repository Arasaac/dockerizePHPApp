<?php
	/**
	 * This class uploads a file, without refreshing the page (Using Javascript)
	 * 
	 * @author Rochak Chauhan
	 * 
	 * @todo all the PHP 4.x users are requested to remove "PUBLIC", "PRIVATE" and "PROTECTED" keywords before the functions
	 * @version 2 
	 * 
	 */
	//session_start();
	
	class AjaxFileuploader {
		
		// PHP 4.x users replace "PRIVATE" from the following lines with VAR
		var $uploadDirectory = '';
		var $uploaderIdArray = array();
		
		/**
		 * Constructor Function
		 * 
		 */
		function AjaxFileuploader($uploadDirectory) {
			
			if (trim($uploadDirectory) != '' && is_dir($uploadDirectory)) {
				$this->uploadDirectory = $uploadDirectory;
			}
			else {
				die("<b>ERROR:</b> No se ha podido abrir el directorio: $uploadDirectory");
			}
		}
		
		/**
		 * @todo This function only scans in one level. you can modify this function to read from the subdirectries too
		 * 
		 * This function return all the files in the upload directory, sorted according to their file types
		 *
		 * @return array
		 */		
		function getAllUploadedFiles() {
			$returnArray = array();
			
			$allFiles = $this->scanUploadedDirectory();
						
			$returnArray['images'] = $this->returnUplodedImages($allFiles);
			$returnArray['sounds'] = $this->returnUplodedSounds($allFiles);
			$returnArray['videos'] = $this->returnUplodedVideos($allFiles);
			$returnArray['others'] = $this->returnMiscUplodedFiles($allFiles);
			
			return $returnArray;
		}
		
		/**
		 * 
		 * This function scans uploaded directory and returns all the files in it
		 *  
		 * @return array
		 */
		function scanUploadedDirectory() {
			$returnArray = array();
			
			if ($handle = opendir($this->uploadDirectory)) {
			   
				while (false !== ($file = readdir($handle))) {
			    	 if (is_file($this->uploadDirectory."/".$file)) {
			    	 	$returnArray[] = $file;
			    	 }
				}
			
			   closedir($handle);
			}
			else {
				die("<b>ERROR: </b> No puede leerse el directorio: ". $this->uploadDirectory);
			}
			return $returnArray;			
		}
		
		
		/**
		 * This function returns html code for uploading a file
		 * 
		 * @param string $uploaderId
		 * 
		 * @return string
		 */
		function showFileUploader($uploaderId) {
			if (in_array($uploaderId, $this->uploaderIdArray)) {
				die($uploaderId." already used. please choose another id.");
				return '';
			}
			else {
				$this->uploaderIdArray[] = $uploaderId;
			
				return '<form id="formName'.$uploaderId.'" method="post" enctype="multipart/form-data" action="inc/imageupload.php" target="iframe'.$uploaderId.'">
							<input type="hidden" name="id" value="'.$uploaderId.'" />
							<span id="uploader'.$uploaderId.'" style="font-family:verdana;font-size:10;">
								Upload File: <input name="'.$uploaderId.'" type="file" value="'.$uploaderId.'" onchange="return uploadFile(this)" />
							</span>
							<iframe name="iframe'.$uploaderId.'" src="inc/imageupload.php" width="400" height="100" style="display:none"> </iframe>
						</form>';
			}
		}
	}
?>
