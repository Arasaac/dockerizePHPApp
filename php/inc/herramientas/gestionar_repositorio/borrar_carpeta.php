<?php 
session_start();

function rm_recursive($filepath)
{
    if (is_dir($filepath) && !is_link($filepath))
    {
        if ($dh = opendir($filepath))
        {
            while (($sf = readdir($dh)) !== false)
            {
                if ($sf == '.' || $sf == '..')
                {
                    continue;
                }
                if (!rm_recursive($filepath.'/'.$sf))
                {
                    throw new Exception($filepath.'/'.$sf.' no pudo ser borrado.');
                }
            }
            closedir($dh);
        }
        return rmdir($filepath);
    }
    return unlink($filepath);
}

/******************************************************************************************************************/

include ('../../../classes/querys/query.php');
include ('../../../funciones/funciones.php');

$query=new query();
$dir=$query->datos_directorio($_GET['idd'],$_SESSION['ID_USER']);

if ($dir['parent'] !=0) {
	$borrar=$query->borrar_directorio($_GET['idd'],$_SESSION['ID_USER'],$dir['parent'],$dir['ruta_dir']);
	
	$dir='../../../usuarios/'.$dir['ruta_dir'];
	
	$folder_delete=rm_recursive($dir);
	
	echo $folder_delete;
}

?>