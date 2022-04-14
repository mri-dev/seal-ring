<?
	class Place{
		private static $img_root		= IMG;
        private static $opened_def_cover_files = null;
		private static $sub_img_root 	= 'icons/';
		const DEFAULT_PHONE_ICON 		= "cont_phone_icon.png";
		const DEFAULT_DESC_STR 			= "Látogassa meg a(z) <strong>{{PLACE_NAME}}</strong> helyet, ha <strong>{{PLACE_CITY}}</strong> környékén jár és ezt keresi: <strong>{{PLACE_TYPE}}</strong>.";
		const DISTANCE_PLACE_STYLE      = 'distPlace';
        const DEFEAULT_COVER_IMG_PATH   = 'default_covers/';

		final public static function showContactInfo($contact_type = null, $place_data_arry, $phone_icon = self::DEFAULT_PHONE_ICON){
			if($place_data_arry[$contact_type] == '' || is_null($contact_type)) return false;
			echo '<table cellspacing="0" cellpadding="0" height="15">
				<tr>
					<td><img width="15" height="15" src="'.self::$img_root.self::$sub_img_root.$phone_icon.'" alt="'.$place_data_arry['name'].'" title="'.__('Telefonszám').'"> '.$place_data_arry[$contact_type].'</td>
					<td></td>
				</tr>
			</table>';
		}

        final public static function getCoverImg($img){
            $rimg = '';

            if(strpos($img,IMG) === false){
                $rimg = substr(IMG,0).$img;
            }

            return $rimg;
        }

        final public static function getOpens($serialized_open_strings){
            $opens = array();
                $o = unserialize($serialized_open_strings);
            $opens = $o;
            return $opens;
        }

        final public static function getAddress($place_data_arry){
            $addr = '';

            if($place_data_arry['loc_irsz'] != 0) $addr .= $place_data_arry['loc_irsz'].' ';
            $addr .= $place_data_arry['loc_city'];
            if($place_data_arry['loc_addr'] != '') $addr .= ', '.$place_data_arry['loc_addr'];

            return $addr;
        }

        final public static function getIdByUrl($str){
            $xs = explode('_-',$str);
            return (int)$xs['1'];
        }

        final public static function getUrl($place_data_arry, $arg = array()){
            $back = '';
            $subpage = ($arg['sub']) ? '/'.$arg['sub'] : '';
            $back = DOMAIN.'hely/'.Helper::makeSafeUrl($place_data_arry['loc_city'].'-'.$place_data_arry['type_name'].'-'.$place_data_arry['name'],'_-'.$place_data_arry['place_id']).$subpage;
            return $back;
        }

        /**
         * Egy hely leírását mutatja meg.
         *
         * @param array $place_data_arry A hely adatai.
         * @param string $description_data_key Az adathalmaz rekord azonosítója, ami visszaadja a tulajdonos által megadott leírást a helyről.
         * @param array $arg0 Paraméterek.
         *
         * @return string Formázott leírás a helyről.
         */
		final public static function getDescription($place_data_arry, $description_data_key, $arg0 = array()){
			$ret = self::DEFAULT_DESC_STR;

                if($place_data_arry[$description_data_key] != '' && !is_null($place_data_arry[$description_data_key])){
                    $ret = $place_data_arry[$description_data_key];
                }

                $ret = self::changeStrToVars($ret,array(
                    "PLACE_NAME" => $place_data_arry['name'],
                    "PLACE_CITY" => $place_data_arry['loc_city'],
                    "PLACE_TYPE" => $place_data_arry['type_name']
                ));
				$ret = self::changeStrToVars($ret);
			return $ret;
		}

        /**
         * Visszaadja egy hely ittettünk.hu-s elérési útját.
         *
         * @param array $place_data_arry A hely adatai.
         * @param array $arg0 (Opc) Paraméterek.
         *
         * @return string ittettünk.hu-s elérési út.
         */
        final public static function getIttettunkUrl($place_data_arry, $arg0 = array()){
            $ret = "";
                if($arg0['id'] != ''){
                    $place_data_arry['id'] = $arg0['id'];
                }
                $ret = ITTETTUNK_PLACE_URL.$place_data_arry['id'].'/'.Helper::makeSafeUrl($place_data_arry['name'],'');
            return $ret;
        }

        final public static function getIttettunkImgUrl($img_data_arry, $place_data_arry, $arg0 = array()){
            $url = '';
            $img_id = '';

            if($img_data_arry['id'] != ''){
                $img_id = $img_data_arry['id'].'/';
            }

            $url = DOMAIN_ITTETTUNK.'place/'.$place_data_arry['place_id'].'/photos/'.$img_id.Helper::makeSafeUrl($place_data_arry['name'],'');

            return $url;
        }

        final public static function defCoverImg($arg = array()){
            $img = '';
            $path = self::$img_root.self::DEFEAULT_COVER_IMG_PATH;

            if(is_null(self::$opened_def_cover_files)){
                $file = File::showFolderFiles($path);
            }else{
                $file = self::$opened_def_cover_files;
            }
            return $file;
        }
        /**
         * Kiírathatjuk egy hely távolságát formázottan.
         *
         * @param float $distance_in_km A hely távolsága kilóméterben
         * @param string $style A kiíratás stílusa.
         *
         * @return string A formázott távolsát km/m-ben.
         */
        final public static function showDistance($distance_in_km, $style = self::DISTANCE_PLACE_STYLE){
            $distance = false;
            if($distance_in_km == '' || $distance_in_km == 0) return '';
            $d = (float)$distance_in_km;
                if($d > 1){
                    $distance = number_format($d,0,"","").' km';
                }else{
                    $distance = number_format($d*1000,0,"","").' m';
                }
            return '<span class='.$style.'>'.$distance.'</span>';
        }
        final public static function logClick($url,$type,$id){
            $reto = '';
                $url    = base64_encode($url);
                $reto   = DOMAIN.'action/clickLog/'.$url.'/'.$type.'/'.$id;

            return $reto;
        }


        /**
         * Egy helynek visszaadja szöveges tartalomban, hogy mennyi véleményt írtak az adott helyről
         * @param array $place_data_arry A hely adatai.
         * @param string $tipp_data_key A tipp kulcsa a hely adataiban.
         * @param array $arg0 (Opcionális) Paraméterek
         *
         * @return string Vélemények száma, formázva.
         */
        final public static function getTippsStr($place_data_arry, $tipp_data_key, $arg0 = array()){
            $ret = "";
            $tipp_num = ($place_data_arry[$tipp_data_key] != "") ? $place_data_arry[$tipp_data_key] : 0;

            if($tipp_num == 0) return $ret;
                $ret = number_format($tipp_num,0,""," ")." ".__("vélemény");
            return $ret;
        }
		
		/**
		 * Szöveges paraméter kulcsot lecseréli egy megadott változóra.
		 * @param String $target_string A forrás szöveg, amiben a kulcsokat le akarjuk cserélni.
		 * @param array $changes A kulcsokat adjuk meg és a lecserélendő értéket. Pl.:
		 * {{KULCS}} => ÉRTÉK
		 * 
		 * @return string
		 */
		final private static function changeStrToVars($target_string, $changes = array()){
            if(!empty($changes)){
                foreach($changes as $ck => $cv){
                    $target_string = str_replace("{{".strtoupper($ck)."}}",$cv, $target_string);
                }
            }

			return $target_string;
		}
	}
?>