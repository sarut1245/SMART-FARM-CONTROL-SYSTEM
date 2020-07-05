<?php
/*
Copyright 2017 Metro (https://github.com/metropolian)

Permission is hereby granted, free of charge, 
to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. 
*/

    $StoragePath = dirname(__FILE__);
	$StorageDefaultDir = "uploads"; 
	
	function File_PrepareFullname($Dir, $Name, $AutoCreateFolder = true)
	{			
		$Fullpath = rtrim( $Dir, '/');
	
		if ( $AutoCreateFolder )
		{
			if (! is_dir($Fullpath))
				if (! mkdir($Fullpath, 0777, true))
					return null;
		}
		
		return $Fullpath . "/" . $Name;
	}

	function Get_UploadedFiles($UploadName, $AddInfo = true)
	{
		$Res = array();
		if ( isset( $_FILES[$UploadName] ) )
		{
			$FInfo = $_FILES[$UploadName];
			if (empty($FInfo))
				return null;
			if (is_array($FInfo['name']))
			{			
				foreach ($FInfo['name'] as $Key => $Name) 
				{					
					if (($FInfo['error'][$Key] == UPLOAD_ERR_OK)  &&
						($FInfo['name'][$Key] != ''))
					{
						$Res[] = array(
							"name" => $FInfo['name'][$Key],
							"key" => $Key,
							"size" => $FInfo['size'][$Key],
							"error" => $FInfo['error'][$Key],
                            "src" => $FInfo['tmp_name'][$Key],
							"tmp_name" => $FInfo['tmp_name'][$Key] 
							);
							
					}
				}
			}
			else
			{
				if ($FInfo['error'] == UPLOAD_ERR_OK)
					$Res = array( $FInfo );
					
			}
		}
		
		if (count($Res) > 0)
		{
			foreach($Res as &$R)
			{
				$R['filename'] = (strpos($R['name'], '.') !== false) ? strstr( $R['name'], '.', true ) : $R['name'];
				$R['ext'] = pathinfo($R['name'], PATHINFO_EXTENSION  );	
				
				if ( $AddInfo )
				{
					$FInfo = @getimagesize($R['tmp_name']);
					if ($FInfo)
					{	
						$R['image'] = true;
						$R['mime'] = $FInfo['mime'];
						$R['width'] = $FInfo[0];
						$R['height'] = $FInfo[1];
						$R['imagetype'] = $FInfo[2];
					}
				}
			}
		}
		
		return $Res;
	}
	
	function Save_UploadedFiles($Files, $BaseName = null, $AddExt = true)
	{  	global $StorageDefaultDir;
        
		$res = array();
		if ( is_array($Files) )
		{
            $index = 1;
			foreach ($Files as $FInfo)
			{
				 if ($FInfo['error'] == UPLOAD_ERR_OK) 
				 {	                    
                    if ($BaseName != null) 
                    {
                        if ($index == 1)
                            $Name = "{$BaseName}.{$FInfo['ext']}";
                        else
                            $Name = "{$BaseName}-{$index}.{$FInfo['ext']}";
                    }
                    else
                        $Name = $FInfo['name'];
                     
					$Fullname = File_PrepareFullname( $StorageDefaultDir , $Name);
					if ($Fullname != null)
					{
						if ( move_uploaded_file($FInfo['tmp_name'] , $Fullname) );
							$res[] = $Fullname;
					}
                    $index++;
				}
			}
		}
		return $res;
	}
	

?>