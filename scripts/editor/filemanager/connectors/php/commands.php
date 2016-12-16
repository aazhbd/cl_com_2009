<?php
require_once('dbfunctions.php');

function GetFoldersAndFiles( $resourceType, $currentFolder )
{
	dbConn();
    $email = $_GET['e'];
    
    $aFolders	= array() ;
	$aFiles		= array() ;
    
    $r = selectData("select * from user_imgs where user_email = '$email' and stat = 1");
    
    foreach($r as $file)
    {
        $fs = $file['file_size'];
        if($fs > 1) $fs = round($fs);
        else $fs = 1;
        
        $aFiles[] = '<File name="' . ConvertToXmlAttribute( $file['id'] ) . '" size="' . $fs . '" />' ;
    }
    
	natcasesort( $aFolders ) ;
	echo '<Folders>' ;

	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	echo '</Folders>' ;

	natcasesort( $aFiles ) ;
	echo '<Files>' ;

	foreach ( $aFiles as $sFiles )
		echo $sFiles ;

	echo '</Files>' ;
}

function FileUpload( $resourceType, $currentFolder )
{
    dbConn();
    $email = $_GET['e'];
    $sErrorNumber = '0' ;
	$sFileName = '' ;
    $thumb_widthpx = 160;
    
	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] ) )
	{
		$oFile = $_FILES['NewFile'] ;
        $sServerDir = ServerMapFolder( 'tmp', $currentFolder ) ;
        $sServerDir = str_replace('/', '\\', $sServerDir);

		$sFileName = $oFile['name'] ;
		$sOriginalFileName = $sFileName ;
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;

		global $Config ;

		$arAllowed	= $Config['AllowedExtensions'][$resourceType] ;
		$arDenied	= $Config['DeniedExtensions'][$resourceType] ;

		if ( ( count($arAllowed) == 0 || in_array( $sExtension, $arAllowed ) ) && ( count($arDenied) == 0 || !in_array( $sExtension, $arDenied ) ) )
		{
			$iCounter = 0 ;
            
            while ( true )
			{ 
                $sFilePath = $sServerDir . $sFileName;
                
				if ( is_file( $sFilePath ) )
				{
					$iCounter++ ;
					$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
					$sErrorNumber = '201' ;
				}
				else
				{
					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;
                    
					if ( is_file( $sFilePath ) )
                    {
                        $ftype = $_FILES['NewFile']['type'];
                        $file_size = $_FILES['NewFile']['size'];

                        $originalpic = file_get_contents($sFilePath);
                        
                        list($width, $height) = getimagesize($sFilePath);
                        if($width > $thumb_widthpx)
                        {
                            $path = str_replace($sFileName, "", $sFilePath, 1);
                            $thumbpic = getThumbImage($path, $thumb_widthpx, $sFileName);
                        }
                        else
                        {
                            $thumbpic = $originalpic;
                        }

                        if(is_dir($sServerDir))
                        {
                            $res = RemoveFileDir($sServerDir, $sFileName, true);
                        }
                        
                        $table = 'user_imgs';
                        $fields = array('id', 'user_email', 'large_image','thumb_image', 'file_type','status', 'file_name', 'file_size');
                        $values = array(null, $email, $originalpic , $thumbpic,  $ftype,  1,  $sFileName, $file_size);
                        
                        $rs = insertData($table, $fields, $values);
                        if(is_string($rs) || $rs == false)
                        {
                            $sErrorNumber = '202' ;
                        }
                        
                        $oldumask = umask(0) ;
                        chmod( $sFilePath, 0777 ) ;
                        umask( $oldumask ) ;
                    }

					break ;
				}
			}
		}
		else
			$sErrorNumber = '202' ;
	}
	else
		$sErrorNumber = '202' ;

	echo '<script type="text/javascript">' ;
	echo 'window.parent.frames["frmUpload"].OnUploadCompleted(' . $sErrorNumber . ',"' . str_replace( '"', '\\"', $sFileName ) . '") ;' ;
	echo '</script>' ;

	exit ;
}
?>