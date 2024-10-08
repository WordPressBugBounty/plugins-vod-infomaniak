<?php
	/**
	 * Classe permettant d'utiliser simplement les differentes fonctions de l'API vod.
	 * Il est parfaitement possible d'utiliser cette classe independamment du plugin wordpress.
	 * En cas de problemes ou de questions, veuillez contacter support-vod-wordpress@infomaniak.ch
	 *
	 * @author INFOMANIAK
	 * @link http://statslive.infomaniak.ch/vod/api/
	 * @version 1.2
	 * @copyright infomaniak.ch
	 *
	 */

	class vod_api {

		protected $sLogin = "";
		protected $sPassword = "";
		protected $sId = "";
		private $oSoap;
		public $bForceUpdate = false;

		/**
		 * Constructeur prennant les informations de connexions
		 *
		 * @param string $sLogin Login de connexion
		 * @param string $sPassword Mot de passe associe au login
		 * @param string $sId Identifiant de l'espace VOD
		 */
		public function __construct($sLogin, $sPassword, $Id = "") {
			$this->sLogin = $sLogin;
			$this->sPassword = $sPassword;
			$this->sId = $Id;
		}

		/**
		 * Fonction permettant de tester la connectivite avec l'API
		 *
		 * @return boolean
		 */
		public function ping() {
			$oSoap = $this->getSoapAdmin();
			if (!empty ($oSoap)) {
				return $oSoap->ping();
			}
			return false;
		}

		/**
		 * Fonction permettant de tester la connectivite avec l'API
		 *
		 * @return integer
		 */
		public function time() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->time();
				}
			} catch (Exception $oException) {
				$this->debug("time", $oException);
			}
			return 0;
		}

		/**
		 * Fonction permettant de recuperer l'id de l'espace VOD
		 *
		 * @return integer
		 */
		public function getServiceItemID() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return intval($oSoap->getServiceItemID());
				}
			} catch (Exception $oException) {
				$this->debug("getServiceItemID", $oException);
			}
			return 0;
		}

		/**
		 * Fonction permettant de recuperer l'identifiant du groupe auquel est rattache le service
		 *
		 * @return integer
		 */
		public function getGroupID() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return intval($oSoap->getGroupeID());
				}
			} catch (Exception $oException) {
				$this->debug("getGroupID", $oException);
			}
			return 0;
		}

		/**
		 * Fonction permettant de recuperer le nombre de video
		 *
		 * @return integer
		 */
		public function countVideo() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return intval($oSoap->countVideo());
				}
			} catch (Exception $oException) {
				$this->debug("countVideo", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de supprimer une video
		 *
		 * @param integer $iFolderCode
		 * @param string $sFileServerCode
		 * @return boolean
		 */
		public function deleteVideo($iFolderCode, $sFileServerCode) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->deleteVideo($iFolderCode, $sFileServerCode);
				}
			} catch (Exception $oException) {
				$this->debug("deleteVideo", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de renommer une video
		 *
		 * @param integer $iFolderCode
		 * @param string $sFileServerCode
		 * @param string $sName
		 * @return boolean
		 */
		public function renameVideo($iFolderCode, $sFileServerCode, $sName) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->setVideoTitle($iFolderCode, $sFileServerCode, $sName);
				}
			} catch (Exception $oException) {
				$this->debug("renameVideo", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer les dernieres videos
		 *
		 * @return array
		 */
		public function getLastVideo($iLimit, $iPage) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					$result = $oSoap->getLastVideo($iLimit, $iPage);
					return $result;
				}
			} catch (Exception $oException) {
				var_dump($oException);
				$this->debug("getLastVideo", $oException);
			}
			return false;
		}





		/**
		 * Fonction permettant de recuperer les dernieres importations de videos par filtration
		 *
		 * @return array
		 */
		public function getVideoInformation($iFolderCode, $sFileServerCode) {
			$oSoap = $this->getSoapAdmin();
			try {
				if (!empty ($oSoap)) {
					return $oSoap->getVideoInformation($iFolderCode, $sFileServerCode);
				}
			} catch (Exception $oException) {
				$this->debug("getVideoInformation", $oException);
			}
			return false;
		}


		/**
		 * Fonction permettant de recuperer les dernieres importations de videos par filtration
		 *
		 * @return array
		 */
		public function getVideosFromFolder($iFolderCode, $iLimit = 100, $iStart = 0, $sOrder = '', $bAsc = true, $sSearch = "") {
			$oSoap = $this->getSoapAdmin();
			try {
				if (!empty ($oSoap)) {
					return $oSoap->getVideosFromFolder($iFolderCode, $iLimit, $iStart, $sOrder, $bAsc, $sSearch);
				}
			} catch (Exception $oException) {
				$this->debug("getVideosFromFolder", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer les dernieres importations de videos
		 *
		 * @return array
		 */
		public function getLastImportation() {
			$oSoap = $this->getSoapAdmin();
			try {
				if (!empty ($oSoap)) {
					return $oSoap->getLastImportation(15);
				}
			} catch (Exception $oException) {
				$this->debug("getLastImportation", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer les dossiers de cet espace VOD
		 *
		 * @return array
		 */
		public function getFolders() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getFolders();
				}
			} catch (Exception $oException) {
				$this->debug("getFolders", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de savoir s'il y a eu des modifications recemment sur les dossiers
		 *
		 * @return boolean
		 */
		public function folderModifiedSince($date) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->folderModifiedSince($date);
				}
			} catch (Exception $oException) {
				$this->debug("folderModifiedSince", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer les players de cet espace VOD
		 *
		 * @return array
		 */
		public function getPlayers() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getPlayers();
				}
			} catch (Exception $oException) {
				$this->debug("getPlayers", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de savoir s'il y a eu des modifications recemment sur les players
		 *
		 * @return boolean
		 */
		public function playerModifiedSince($date) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->playerModifiedSince($date);
				}
			} catch (Exception $oException) {
				$this->debug("PlayerModifiedSince", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer les playlists de cet espace VOD
		 *
		 * @return array
		 */
		public function getPlaylists() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getPlaylists();
				}
			} catch (Exception $oException) {
				$this->debug("getPlaylists", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de savoir s'il y a eu des modifications recemment sur les playlist
		 *
		 * @return boolean
		 */
		public function playlistModifiedSince($date) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->playlistModifiedSince($date);
				}
			} catch (Exception $oException) {
				$this->debug("playlistModifiedSince", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant d'obtenir un token d'upload
		 *
		 * @return string
		 */
		public function initUpload($sPath) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->initUpload($sPath);
				}
			} catch (Exception $oException) {
				$this->debug("initUpload", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de lancer le telechargement d'une video
		 *
		 * @return boolean
		 */
		public function importFromUrl($sPath, $sUrl, $aOptions) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->importFromUrl($sPath, $sUrl, $aOptions);
				}
			} catch (Exception $oException) {
				$this->debug("importFromUrl", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant d'ajouter des infos a une ou plusieurs videos
		 *
		 * @return boolean
		 */
		public function addInfo($sToken, $sInfo) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->addInfo($sToken, $sInfo);
				}
			} catch (Exception $oException) {
				$this->debug("addInfo", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer l'adresse de callback actuellement en place
		 *
		 * @return string
		 */
		public function getCallback() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getCallbackUrl();
				}
			} catch (Exception $oException) {
				$this->debug("getCallback", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer l'adresse des callback actuellement en place
		 *
		 * @return array
		 */
		public function getCallbackV2() {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getCallbackUrlV2();
				}
			} catch (Exception $oException) {
				$this->debug("getCallback", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de definir l'adresse de callback
		 *
		 * @param string $sUrl Nouvelle adresse de callback
		 * @return boolean
		 */
		public function setCallback($sUrl) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->setCallbackUrl($sUrl);
				}
			} catch (Exception $oException) {
				$this->debug("setCallback", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de definir l'adresse de callback
		 *
		 * @param string $sUrl Nouvelle adresse de callback
		 * @return boolean
		 */
		public function setCallbackV2($sUrl) {
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->setCallbackUrlV2($sUrl);
				}
			} catch (Exception $oException) {
				$this->debug("setCallback", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer l'URL d'un player
		 *
		 * @return string
		 */
		public function publishShare($video,$player,$width,$height) {
			
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->publishShare($video,$player,$width,$height);
				}
			} catch (Exception $oException) {
				$this->debug("publishShare", $oException);
			}
			return false;
		}

		/**
		 * Fonction permettant de recuperer l'URL d'un player protégé par TOKEN
		 *
		 * @return string
		 */
		public function publishShareWithToken($video,$player,$width,$height) {
			
			$infos = explode('/', $video);

			// Generate token
			date_default_timezone_set('UTC');

			$body = array(
		        	"start_time" => date("Y-m-d H:i:s"),
		        	"window" => 300,
		        	"allowed_domains" => [ get_option("siteurl") ],	
		        	"strategy" => "hls"
		    	);
			
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getShareAndToken($video,$player,$body);
				}
			} catch (Exception $oException) {
				$this->debug("getShareAndToken", $oException);
			}


		}

		/**
		 * Fonction permettant de recuperer des informations de version
		 *
		 * @return string
		 */
		public function getCmsInfo(){
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getCmsInfo();
				}
			} catch (Exception $oException) {
				$this->debug("getCmsInfo", $oException);
			}
			return "";			
		}

		/**
		 * Fonction permettant de setter des informations de version
		 *
		 * @return string
		 */
		public function setCmsInfo($info){
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->setCmsInfo($info);
				}
			} catch (Exception $oException) {
				$this->debug("setCmsInfo", $oException);
			}
			return "";			
		}

		/**
		 * Fonction permettant de voir la progression d'un encodage
		 *
		 * @return int
		 */
		public function getProgress($video){
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getProgress($video);
				}
			} catch (Exception $oException) {
				$this->debug("getProgress", $oException);
			}
			return "";			
		}

		
		public function getMediaState($video){
			try {
				$oSoap = $this->getSoapAdmin();
				if (!empty ($oSoap)) {
					return $oSoap->getMediaState($video);
				}
			} catch (Exception $oException) {
				$this->debug("getMediaState", $oException);
			}
			return "";			
		}

		private function debug($sFunction, $oException) {
			if (WP_DEBUG) {
				echo "<h4 style='color:red'>Debug :: vod_api -> " . $sFunction . "()</h4><code>";
				var_dump($oException);
				echo "</code>";
			}
		}


		private function getSoapAdmin() {


			if (!empty ($this->oSoap)) {
				return $this->oSoap;
			} else {
				$response = wp_remote_get( esc_url_raw( 'https://vod.infomaniak.com/status.php?account='.$this->sId));	//&force=2
				$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

				$old_version = get_option( 'vod_api_version', false );



				if ($api_response['bMigrated'] === "0"){
					$version = 1;
					$sSoap = "http://statslive.infomaniak.com/vod/api/vod_soap.wsdl";
				}else{
					$version = 2;
					if (intval($api_response['item']) < 10000){
						$sSoap = "https://api.vod2.infomaniak.com/v1soap/soap/wsdl";
					}else{
						$sSoap = "https://api.vod2.infomaniak.com/v1soap/soap/wsdl2";
					}
				}
				if (empty(get_option( 'vod_api_version', false ))){
					add_option( "vod_api_version", $version );
				}else{
					update_option( "vod_api_version", $version );
				}

				if ($old_version != $version){
					$this->bForceUpdate = true;
				}

				$ctx = stream_context_create(array("ssl" => array("verify_peer" => false, "verify_peer_name" => false,)));

				$aOptions = array(
					'trace' => 1,
					'encoding' => 'UTF-8',
					'exceptions' => true, 
					'cache_wsdl' => WSDL_CACHE_NONE,
					'stream_context' => $ctx
				);

				$this->oSoap = new SoapClient ($sSoap, $aOptions);
				try {
					$this->oSoap->__setSoapHeaders(array(new SoapHeader ('urn:vod_soap', 'AuthenticationHeader', new SoapVODAuthentificationHeader ($this->sLogin, $this->sPassword, $this->sId))));
					return $this->oSoap;
				} catch (Exception $oException) {
					$this->debug("getSoapAdmin", $oException);
				}
				return false;
			}
		}
	}

	ini_set("soap.wsdl_cache_enabled", 0);


	class SoapVODAuthentificationHeader {
		public $Password;
		public $sLogin;
		public $sVod;

		public function __construct($sLogin, $sPassword, $sVod) {
			$this->sPassword = $sPassword;
			$this->sLogin = $sLogin;
			$this->sVod = $sVod;
		}
	}

?>
