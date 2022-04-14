<?
class Format{
    final public static function ora($ora_str){
        $formated = $ora_str;
            $exp = explode(':',$formated);
            $formated = $exp['0'].'<sup>'.$exp['1'].'</sup>';
        return $formated;
    }
    final public static function timeAdd($time, $add){
        $formated = date('Y-m-d H:i:s');

        $time = ($time == '') ? $formated : $time;
        $add = ($add == '') ? '+0 sec' : $add;


        $formated = date('Y-m-d H:i:s',strtotime($time.$add));

        return $formated;
    }
}
?>