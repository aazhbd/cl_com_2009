<?php 
include('dbfunctions.php') ;
include('io.php') ;
include('config.php') ;
include('util.php') ;
include('basexml.php') ;
include('commands.php') ;

if ( !$Config['Enabled'] )
	SendError( 1, 'This connector is disabled. Please check the "editor/filemanager/connectors/php/config.php" file' ) ;

$GLOBALS["UserFilesPath"] = '' ;

if ( isset( $Config["UserFilesPath"] ) )
{
	$GLOBALS["UserFilesPath"] = $Config["UserFilesPath"];
}
else if ( isset( $_GET['ServerPath'] ) )
	$GLOBALS["UserFilesPath"] = $_GET['ServerPath'] ;
else
	$GLOBALS["UserFilesPath"] = '/UserFiles/' ;
    

if ( isset( $Config["UserFilesDirectory"] ) )
{
    $GLOBALS["ServerFilesPath"] = $Config["UserFilesDirectory"];
}
else if ( isset( $_GET['ServerPath'] ) )
    $GLOBALS["UserFilesPath"] = $_GET['ServerPath'] ;
else
    $GLOBALS["ServerFilesPath"] = '/UserFiles/' ;

if ( ! ereg( '/$', $GLOBALS["UserFilesPath"] ) )
	$GLOBALS["ServerFilesPath"] .= '/' ;


if ( strlen( $Config['UserFilesAbsolutePath'] ) > 0 ) 
{
	$GLOBALS["UserFilesDirectory"] = $Config['UserFilesAbsolutePath'] ;

	if ( ! ereg( '/$', $GLOBALS["UserFilesDirectory"] ) )
		$GLOBALS["UserFilesDirectory"] .= '/' ;
}
else
{
	$GLOBALS["UserFilesDirectory"] = GetRootPath() . $GLOBALS["ServerFilesPath"] ;
}

DoResponse() ;

function DoResponse()
{
	if ( !isset( $_GET['Command'] ) || !isset( $_GET['Type'] ) || !isset( $_GET['CurrentFolder'] ) )
		return ;

	$sCommand		= $_GET['Command'] ;
	$sResourceType	= $_GET['Type'] ;
	$sCurrentFolder	= $_GET['CurrentFolder'] ;

	if ( !in_array( $sResourceType, array('File','Image','Flash','Media') ) )
		return ;

	if ( ! ereg( '/$', $sCurrentFolder ) ) $sCurrentFolder .= '/' ;
	if ( strpos( $sCurrentFolder, '/' ) !== 0 ) $sCurrentFolder = '/' . $sCurrentFolder ;
	
	if ( strpos( $sCurrentFolder, '..' ) )
		SendError( 102, "" ) ;

	if ( $sCommand == 'FileUpload' )
	{
		FileUpload( $sResourceType, $sCurrentFolder ) ;
		return ;
	}

	CreateXmlHeader( $sCommand, $sResourceType, $sCurrentFolder ) ;

	switch ( $sCommand )
	{
		case 'GetFoldersAndFiles' :
			GetFoldersAndFiles( $sResourceType, $sCurrentFolder ) ;
			break ;
	}

	CreateXmlFooter() ;

	exit ;
}
?>