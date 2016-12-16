<?php
function GetUrlFromPath( $resourceType, $folderPath )
{
	if ( $resourceType == '' )
		return RemoveFromEnd( $GLOBALS["UserFilesPath"], '/' ) . $folderPath ;
	else
		return $GLOBALS["UserFilesPath"] . RemoveFromStart($folderPath, '/') ;
}

function RemoveExtension( $fileName )
{
	return substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
}

function RemoveFileDir($current_dir, $filename, $isFile)
{
    if (!file_exists($current_dir))
        return false;
    
    if (is_file($current_dir) || is_link($current_dir)) 
        return unlink($current_dir);
        
    if($dir = @opendir($current_dir)) 
    {
        while (($f = readdir($dir)) !== false) 
        {
            if($f > '0' and filetype($current_dir.$f) == "file"  && $isFile == true) 
            {
                if(basename($current_dir.$f) == $filename)
                {
                    unlink($current_dir.$f);
                    break;
                }
            } 
            elseif($f > '0' and filetype($current_dir.$f) == "dir" && $isFile == false) 
            {
                if(basename($current_dir.$f) == $filename)
                {
                    remove_dir($current_dir.$f."\\");
                    break;
                }
            }
        }
        closedir($dir);
    }
}

function RemoveDir($dirname)
{
    if (!file_exists($dirname))
        return false;
    
    if (is_file($dirname) || is_link($dirname)) 
        return unlink($dirname);
        
    $stack = array($dirname);
    while ($entry = array_pop($stack)) 
    {
        if (is_link($entry)) 
        {
            unlink($entry);
            continue;
        }
        
        if (@rmdir($entry))
            continue;

        $stack[] = $entry;
        $dh = opendir($entry);
        while (false !== $child = readdir($dh)) 
        {
            if ($child === '.' || $child === '..')
                continue;

            $child = $entry . DIRECTORY_SEPARATOR . $child;
            if (is_dir($child) && !is_link($child))
                $stack[] = $child;
            else 
                unlink($child);
        }
        closedir($dh);
    }
    
    return true;
}

function ServerMapFolder( $resourceType, $folderPath )
{
	$sResourceTypePath = $GLOBALS["UserFilesDirectory"] . $resourceType . '/' ;
    
	CreateServerFolder( $sResourceTypePath ) ;
    
	return $sResourceTypePath . RemoveFromStart( $folderPath, '/' ) ;
}

function GetParentFolder( $folderPath )
{
	$sPattern = "-[/\\\\][^/\\\\]+[/\\\\]?$-" ;
	return preg_replace( $sPattern, '', $folderPath ) ;
}

function CreateServerFolder( $folderPath )
{
	$sParent = GetParentFolder( $folderPath ) ;

	if ( !file_exists( $sParent ) )
	{
		$sErrorMsg = CreateServerFolder( $sParent ) ;
		if ( $sErrorMsg != '' )
			return $sErrorMsg ;
	}

	if ( !file_exists( $folderPath ) )
	{
		error_reporting( 0 ) ;
        
		ini_set( 'track_errors', '1' ) ;

		$oldumask = umask(0) ;
		mkdir( $folderPath, 0777 ) ;
		umask( $oldumask ) ;

		$sErrorMsg = $php_errormsg ;

		ini_restore( 'track_errors' ) ;
		ini_restore( 'error_reporting' ) ;

		return $sErrorMsg ;
	}
	else
		return '' ;
}

function GetRootPath()
{
	$sRealPath = realpath( './' ) ;

	$sSelfPath = $_SERVER['PHP_SELF'] ;
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ) ) ;

	return substr( $sRealPath, 0, strlen( $sRealPath ) - strlen( $sSelfPath ) ) ;
}

function GetHttpPath()
{
    $HR = (string)$_SERVER['HTTP_REFERER'];
    $ar = explode("/", $HR);
    $path = $ar[0] .'/'. $ar[1] .'/'. $ar[2] .'/'. $ar[3];
    return $path;
}
?>