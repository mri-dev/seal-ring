<?
	class Location{
		private static $geolocate_url = 'http://maps.googleapis.com/maps/api/geocode/json?address=';
		static function getPosition($addr){
			$geo = self::geolocate($addr);
			return $geo['xy'];
		}
		
		private static function geolocate($addr){
			$url 	= self::$geolocate_url.urlencode($addr).'&sensor=true';
			
			$jret 	= file_get_contents($url);	
			
			$data = json_decode($jret);
			$ret['data'] = $data;
			$ret['xy']['lat'] = ($data->results['0']->geometry->location->lat) ? $data->results['0']->geometry->location->lat : $data->results->geometry->location->lat;
			$ret['xy']['lng'] = ($data->results['0']->geometry->location->lng) ? $data->results['0']->geometry->location->lng : $data->results->geometry->location->lng; 
			
			return $ret;
		}
	}
?>