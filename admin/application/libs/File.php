<?
class File{
    final public static function showFolderFiles($root){
        $ret 	= array();
        $root 	= ltrim($root,'/');
        try{
            $r = new DirectoryIterator($root);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

        foreach ($r as $file) {
            if($file->isDot()||$file->isDir()) continue;
            $src = $file->getPath().'/'.$file->getFilename();
            $size = getimagesize($src);
            list($sinfo[sz],$sinfo[m]) = $size;
            $ret[] = array(
                "src" => '/'.$src,
                "name" => $file->getFilename(),
                "ido" => date("Y-m-d H:i:s", fileatime($src)),
                "timeStamp" => $file->getCTime(),
                "info" => $sinfo,
                "size" => array(
                    "byte" => filesize($src),
                    "kb" => number_format(filesize($src) / 1024,2,".",""),
                    "mb" => number_format(filesize($src) / 1024 / 1024,2,".","")
                )
            );
        }

        return $ret;
    }
}
?>