<?
namespace PortalManager;

/**
* class Helpdesk
* @package PortalManager
* @version v1.0
*/
class Helpdesk
{
  const DB_CATEGORIES = 'tudastar_kategoriak';
  const DB_LIST = 'tudastar_cikkek';
	private $db = null;


	function __construct( $arg = array() )
	{
		$this->db = $arg[db];
	}

  public function getCategoryData( $id = false )
  {
    if ( !$id ) {
      return false;
    }

    $q = "SELECT c.* FROM ".self::DB_CATEGORIES." as c WHERE c.ID = ".$id;

    $get = $this->db->query($q);

    if ( $get->rowCount() == 0 ) {
      return false;
    }

    return $get->fetch(\PDO::FETCH_ASSOC);
  }

  public function getArticleData( $id = false )
  {
    if ( !$id ) {
      return false;
    }

    $q = "SELECT c.* FROM ".self::DB_LIST." as c WHERE c.ID = ".$id;

    $get = $this->db->query($q);

    if ( $get->rowCount() == 0 ) {
      return false;
    }

    return $get->fetch(\PDO::FETCH_ASSOC);
  }

  public function categoryModifier( $mode = false, $data )
  {
    if ( !$mode ) {
      return false;
    }

    $id = $data['id'];

    unset( $data['categoryModifier'] );
    unset( $data['id'] );

    switch ( $mode )
    {
      case 'add':
        if ( empty($data['cim']) ) {
          throw new \Exception("A témakör címét kötelező megadni.");
        }

        $this->db->insert(
          self::DB_CATEGORIES,
          $data
        );

        return "A(z) <strong>".$data['cim']."</strong> témakört sikeresen létrehoztuk.";

      break;
      case 'edit':
        if ( !$id || $id == '') {
          throw new \Exception("Hiányzik a témakör ID-ja, így nem tudjuk a műveletet elvégezni.");
        }

        $this->db->update(
          self::DB_CATEGORIES,
          $data,
          sprintf("ID = %d", $id)
        );
        return "A(z) <strong>".$data['cim']."</strong> témakör változásai sikeresen mentve lettek.";
      break;
      case 'del':
        if ( !$id || $id == '') {
          throw new \Exception("Hiányzik a témakör ID-ja, így nem tudjuk a műveletet elvégezni.");
        }
        $this->db->query("DELETE FROM ".self::DB_CATEGORIES." WHERE ID = ".$id);
        return "A témakört véglegesen töröltük a rendszerből.";
      break;

      default:
        return false;
      break;
    }
  }

  public function articleModifier( $mode = false, $data )
  {
    if ( !$mode ) {
      return false;
    }

    $id = $data['id'];

    unset( $data['articleModifier'] );
    unset( $data['id'] );

    switch ( $mode )
    {
      case 'add':
        if ( empty($data['cim']) ) {
          throw new \Exception("A cikk címét kötelező megadni.");
        }
        if ( empty($data['katID']) ) {
          throw new \Exception("A cikk témakörét kötelezően ki kell választani.");
        }
        if ( empty($data['szoveg']) ) {
          throw new \Exception("A cikk tartalmát kötelező megadni.");
        }

        $data['kiemelt'] = (isset($data['kiemelt'])) ? 1 : 0;

        $this->db->insert(
          self::DB_LIST,
          $data
        );

        return "A(z) <strong>".$data['cim']."</strong> cikket sikeresen létrehoztuk.";

      break;
      case 'edit':
        if ( !$id || $id == '') {
          throw new \Exception("Hiányzik a cikk ID-ja, így nem tudjuk a műveletet elvégezni.");
        }

        $data['kiemelt'] = (isset($data['kiemelt'])) ? 1 : 0;

        $this->db->update(
          self::DB_LIST,
          $data,
          sprintf("ID = %d", $id)
        );
        return "A(z) <strong>".$data['cim']."</strong> cikk változásai sikeresen mentve lettek.";
      break;
      case 'del':
        if ( !$id || $id == '') {
          throw new \Exception("Hiányzik a cikk ID-ja, így nem tudjuk a műveletet elvégezni.");
        }
        $this->db->query("DELETE FROM ".self::DB_LIST." WHERE ID = ".$id);
        return "A cikket véglegesen töröltük a rendszerből.";
      break;

      default:
        return false;
      break;
    }
  }

  public function getCategories( $get_articles = false, $arg = array() )
  {
    $data = array();
    $count = 0;

    $q = "SELECT
      c.ID,
      c.cim,
      c.sorrend,
      (SELECT count(l.ID) FROM ".self::DB_LIST." as l WHERE l.katID = c.ID) as itemcount
    FROM ".self::DB_CATEGORIES." as c
    WHERE 1=1";

    $q .= " ORDER BY c.sorrend ASC";

    $get = $this->db->query($q);

    if ($get->rowCount() != 0) {
      $get = $get->fetchAll(\PDO::FETCH_ASSOC);
      foreach ($get as $d) {
        $d['ID'] = (int)$d['ID'];
        $d['cim'] = __($d['cim']);
        if ($get_articles) {
          if ( isset($arg['in_cat']) && !empty($arg['in_cat']) ) {
            if( in_array($d['ID'], $arg['in_cat'])){
              $d['articles'] = $this->getArticles( $d['ID'], $arg );
            } else {
              $d['articles'] = array();
            }
          } else {
            $d['articles'] = $this->getArticles( $d['ID'], $arg );
          }

          $count += count($d['articles']);
        }
        $data[] = $d;
      }
    }

    return array( 'data' => $data, 'count' => $count );
  }

  public function getArticles( $by_category = false, $arg = array() )
  {
    $data = array();
    $q = "SELECT
      c.ID,
      c.cim,
      c.katID,
      c.szoveg,
      c.kulcsszavak,
      c.kiemelt,
      c.sorrend,
      c.idopont
    FROM ".self::DB_LIST." as c
    WHERE 1=1";

    if ( isset($arg['kiemelt']) ) {
      if ($arg['kiemelt'] === true) {
        $q .= " and c.kiemelt = 1";
      } elseif( $arg['kiemelt'] === false ){
        $q .= " and c.kiemelt = 1";
      }
    }

    if ( $by_category ) {
      $q .= " and katID = ".$by_category;
    }

    $q .= " ORDER BY c.sorrend ASC";

    $get = $this->db->query($q);

    if ($get->rowCount() != 0) {
      $get = $get->fetchAll(\PDO::FETCH_ASSOC);
      foreach ($get as $d) {
        $d['ID'] = (int)$d['ID'];
        $d['kulcsszavak'] = $this->keywordTrimmer( $d['kulcsszavak'] );

        if( DLANG !== \Lang::getLang())
        {
          $translates = $this->db->getTranslateContents( self::DB_LIST, $d['ID'], \Lang::getLang() );
          
          if( $translates )
          {
            $translate_keys = ['cim', 'szoveg', ];
            foreach( $translate_keys as $tk )
            {
              if( isset($translates[$tk]['content']) && !empty($translates[$tk]['content']) )
              {
                $d[$tk] = $translates[$tk]['content'];
              }
            }				
          }
        }

        // Kulcsszó keresések
        if ( isset($arg['search']) ) {
          if ( !$this->searchByKeywords( $d, $arg['search'] ) ) {
            continue;
          }
        }

        $this->prepareArticlesContent( $d['szoveg'] );

        $data[] = $d;
      }
    }

    return $data;
  }

  public function getTranslates( $article_id, $lang)
  {
    $translates = $this->db->getTranslateContents( self::DB_LIST, $article_id, $lang );
		return $translates;
  }

  public function saveTranslates( $id, $langset )
	{
		if( $langset )
		{
			foreach( $langset as $langkey => $items )
			{
				foreach( (array)$items as $key => $i )
				{
					$this->db->createTranslateContent( $i, self::DB_LIST, $key, $langkey, $id );
				}
			}
		}
	}

  private function prepareArticlesContent( &$content )
  {
    $content = str_replace(array(
      '../src/'
    ),
    array(
      SOURCE
    ), $content);

    return $content;
  }

  public function searchByKeywords( $data, $search )
  {
    $valid = false;

    foreach ( (array)$search as $src ) {
      $src = strtolower($src);
      if (
        in_array($src,$data['kulcsszavak']) ||
        strpos(strtolower($data['cim']), $src) !== false ||
        strpos(strtolower($data['szoveg']), $src) !== false
      ) {
        $valid[] = $src;
      }
    }

    return $valid;
  }

  private function keywordTrimmer( $keywords = '', $separator = ',' )
  {
    $keys = array();
    $xkeys = explode($separator, $keywords);
    foreach ($xkeys as $key) {
      $keys[] = trim($key);
    }

    return $keys;
  }

	/*-----  End of GETTERS  ------*/
	public function __destruct()
	{
		$this->db = null;
	}
}
?>
