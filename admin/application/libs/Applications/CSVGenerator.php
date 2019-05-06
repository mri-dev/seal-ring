<?
namespace Applications;

class CSVGenerator
{
	private static $separator 		= ";";
	private static $enclosure 		= '"';
	private static $download_file 	= true;
	private static $csv_head 		= array();
	private static $csv_items 		= array();
	private static $output_filename = 'untitled.csv';
	private static $encode 			= 'iso-8859-2';

	public static function prepare($head = array(), $items = array(), $fileName = 'untitled'){
		self::$csv_head 		= $head;
		self::$csv_items 		= $items;
		self::$output_filename 	= $fileName.'.csv';
	}

	public static function changeSeparator($sep){
		if($sep != ''){
			self::$separator = trim($sep);
		}
	}

	public static function changeEncoding( $charset )
	{
		self::$encode = $charset;
	}

	private static function conv( $str )
	{
		return iconv( 'UTF-8', self::$encode, $str);
	}

	public static function run( $downloading = true ){
		$data 	= array();

		self::$download_file = $downloading;

		if(count(self::$csv_head) > 0){
			$data[] = self::$csv_head;
		}

		$item = self::$csv_items;

		if(count($item) == 0){return false;}
		foreach($item as $i){
			$data[] = $i;
		}


		if(self::$download_file){
			$filename = self::$output_filename;

			header("Content-type: text/csv; charset=".self::$encode);
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");
		}


		if (self::$download_file) {
			$output = fopen("php://output", "w");
		} else {
			$output = fopen(self::$output_filename, "w");
		}

		$file = '';
		$set = array();
		foreach ($data as $row) {
			if( $row && !empty($row) ){
				$into = array();
				foreach($row as $r){
					if(!is_null($r)){
						$into[] = self::conv($r);
					}
				}
				fwrite($output, self::arrayToCsv( $into, self::$separator, '' )."\n");
				//fputcsv($output, $into, self::$separator,'"');
			}
		}

		fclose($output);
	}

	static function arrayToCsv( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false )
	{
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    foreach ( $fields as $field ) {
        if ($field === null && $nullToMysqlNull) {
            $output[] = 'NULL';
            continue;
        }

        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        }
        else {
            $output[] = $field;
        }
    }

    return implode( $delimiter, $output );
	}
}
?>
