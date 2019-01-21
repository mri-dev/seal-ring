<?
namespace Applications;

/**
* class VotePolls
* @package Applications
* @version 1.0
*/
class XMLGenerator 
{
	public $stack_name 	= 'items';
	public $item_head 	= 'item';
	public $head_tags 	= array();
	public $items 		= array();
	private $encode 	= 'UTF-8';
	private $output 	= '';

	public function __construct( $stack_name = 'items', $item_head = 'item', $head, $items )
	{
		$this->stack_name 	= $stack_name;
		$this->head_tags 	= $head;
		$this->item_head 	= $item_head;
		$this->items 		= $items;

		return $this;
	}

	public function build()
	{
		$this->push( '<?xml version="1.0" encoding="'.$this->encode.'"?>' );
		$this->push( '<'.$this->stack_name.'>' );

		
		foreach ( $this->items as $i ) { 
			$this->push( '<'.$this->item_head.'>' );

			$n = -1;
			foreach ( $i as $value) { $n++;
				$val = ($value == '') ? " " : $this->conv( $value ); 
				$this->push( '<'.$this->head_tags[$n].'>' . $val . '</'.$this->head_tags[$n].'>' );
			}

			$this->push( '</'.$this->item_head.'>' );
		}


		$this->push( '</'.$this->stack_name.'>' );

		return $this;
	}

	public function setEncode( $encode )
	{
		$this->encode = $encode;
		return $this;
	}

	private function push( $row )
	{
		$this->output .= $row . "\r\n";
	}

	private function conv( $str )
	{
		return iconv('UTF-8', $this->encode, $str);
	}

	public function export( $filename )
	{
		header("Content-type: application/xml; charset=".$this->encode);
		header('Content-Disposition: attachment; filename="'.$filename.'.xml"');
		header("Content-Transfer-Encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");

		print_r($this->output);
	}
}
?>