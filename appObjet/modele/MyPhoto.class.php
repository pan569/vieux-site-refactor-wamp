<?php
namespace appObjet\modele;

use systeme\exceptions\myException;

class ITCP
{
	
	/**
	 * Document photo sous forme de chaine de caractere
	 *
	 * @var string
	 * @access protected
	 */
	protected $photo;
	/**
	 * lecture Document photo
	 *
	 * @param void
	 * @return string
	 */
	public function getPhoto()
	{
		return 'data:image/jpg,' .  $this->photo ;
	}
	/**
	 * Ecriture Document photo
	 *
	 * @param image JPEG
	 * @return void
	 */
	public function setPhoto($value)
	{
		$this->photo = addslashes ( rawurlencode (file_get_contents ( $value )));
	}
	/**
	 * verifie et assigne un document photo apres un telechargement
	 *
	 * @param string  $value = Variable de téléchargement de fichier via HTTP
	 * @return void
	 */
	public function imagetelecharge($value)
	{
		$taille_max = 25000000;
		$typeMime = 'image/jpeg';
		if ($value['size'] > $taille_max)
		{
			throw new myException( "", 0, 'fichier incorecte', 'Ce fichier fait ' . $value['size'] . ' octées', 'Ce fichier ne serra pas enregistré', 'selectionnez un fichier de moins de ' . $taille_max . ' octées' );
		}
		elseif ($value['type'] != $typeMime)
		{
		    throw new myException ( "", 0, 'fichier incorecte', 'Ce fichier est de type ' . $value['type'], 'Ce Prenom ne va pas etre pris en compte', 'selectionnez un fichier est de type ' . $typeMime );
		} else
		{
			$this->photo = addslashes ( rawurlencode (file_get_contents ($value['tmp_name'])));
		}
		
		//lecture des metadonées ITCP
		$this->LectTag();
	}
	
	/**
	 * Tableau des données ITCP du document photo
	 *
	 * @var array
	 * @access protected
	 */
	public $listTags = array();
	/**
	 * Retourne retourne la valeur d'un Attribut de la classe fille
	 *
	 * @param string
	 * @return mixed
	 */
	public function __get($itcp)
	{
		if(!empty ( $this->photo )  )
		{
			// verifie si l'attribut $property fait bien partit de la classe fille en regardant dans $données
			if(array_key_exists ( $itcp , $this->dictionnaire ))
			{
				if(is_array ($this->listTags[$this->dictionnaire[$itcp]] ))
				{
					$donnée = implode ( ";" , $this->listTags[$this->dictionnaire[$itcp]] );
				}
				else
				{
					$donnée = $this->listTags[$this->dictionnaire[$itcp]] ;
				}
				return $donnée;
			}
		}
		else 
			return null;
	}
	/**
	 * Assigne une valeur a un attribut de la classe fille
	 *
	 * @param string
	 * @return mixed
	 */
	public function __set($itcp, $value)
	{
		// verifie si l'attribut $property fait bien partit de la classe fille en regardant dans $données
		if(array_key_exists ( $itcp , $this->dictionnaire ))
		{
			$this->listTags[$this->dictionnaire[$itcp]]= $value;
		}
	}
	
	/**
	 * liste des tags (code Machines) avec leur significations en francais (parcielement traduit)
	 *
	 * @key string Nom des tag en francais
	 * @value string code machine tel quel dans le document photo
	 *
	 * @var array
	 * @access protected
	 */
	public $dictionnaire = array();
	
	public function __construct()
	{
		// remplis le tableau de definition des tags
		$this->dictionnaire = array(
				'ObjectType' => '2#003',
				'ObjectAttribute' =>'2#004',
				'NomObjet' =>'2#005',
				'EditStatus'=> '2#007',
				'EditorialUpdate' =>'2#008',
				'Priorité' =>'2#010',
				'SubjectReference'=>'2#012',
				'Categorie' =>'2#015',
				'SupplementalCategories' =>'2#020',
				'FixtureIdentifier' =>'2#022',
				'Motsclé' =>'2#025',
				'LocationCode' => '2#026',
				'LocationName' =>'2#027',
				'ReleaseDate' =>'2#030',
				'ReleaseTime' =>'2#035',
				'ExpirationDate' =>'2#037',
				'ExpirationTime' =>'2#038',
				'Instructions' =>'2#040',
				'ActionAdvised' =>'2#042',
				'ReferenceService' =>'2#045',
				'ReferenceDate'=>'2#047',
				'ReferenceNumber' =>'2#050',
				'DateCreated' =>'2#055',
				'TimeCreated' =>'2#060',
				'DigitalDreationDate' =>'2#062',
				'DigitalCreationTime' =>'2#063',
				'OriginatingProgram' =>'2#065',
				'ProgramVersion' =>'2#070',
				'ObjectCycle' =>'2#075',
				'Créateur'  =>'2#080',
				'AuthorsPosition' =>'2#085',
				'Ville' =>'2#090',
				'Emplacement' => '2#092',
				'Region' =>'2#095',
				'CountryCode' =>'2#100',
				'Pays'  =>'2#101',
				'TransmissionReference' =>'2#103',
				'Titre' =>'2#105',
				'Credit' =>'2#110',
				'Source' =>'2#115',
				'Copyright' =>'2#116',
				'ContactInformation' =>'2#118',
				'Description' => '2#120',
				'Auteur' =>'2#122',
				'ImageType'=>'2#130',
				'ImageOrientation' =>'2#131',
				'LanguageIdentifier'=>'2#135',
				'AudioType' =>'2#150',
				'AUdioSampling rate'=>'2#151',
				'AudioSampling resolution' =>'2#152',
				'AudioDuration' =>'2#153',
				'AudioOutcue' =>'2#154',
				'JobID' =>'2#184',
				'MasterDocumentID'=>'2#185',
				'ShortDocumentID' =>'2#186',
				'UniqueDocumentID' =>'2#187',
				'OwnerID' =>'2#188',
				'ObjectPreviewFileFormat' =>'2#200',
				'ObjectPreviewFileVersion' =>'2#201',
				'ObjectPreviewData' =>'2#202',
				'Prefs' =>'2#221',
				'ClassifyState' =>'2#225',
				'SimilarityIndex' =>'2#228',
				'DocumentNotes' =>'2#230',
				'DocumentHistory' =>'2#231',
				'ExifCameraInfo' =>'2#232',
				'CatalogSets' =>'2#255'
		);
		 
	
	}

	/**
	 * Lit lse donnée ITCP du document photo et les sauvegarde dans le tableau des Tags
	 *
	 * @param void
	 * @return void
	 */
	public function LectTag()
	{

		$size = getimagesize($this->getPhoto(), $info);
		
		if(array_key_exists ('APP13', $info ))
		{
			$iptc = iptcparse($info['APP13']);

			foreach($this->dictionnaire as $cle => $valeur)
			{
				if(array_key_exists ($valeur, $iptc ))
				{
					$this->listTags[$valeur] = $iptc[$valeur];
		
				}
				else 
				{
					$this->listTags[$valeur]="";
				}
			}
		}
		else
		{
			foreach($this->dictionnaire as $cle => $valeur)
			{
				$this->listTags[$valeur]="";
			}
		}
		
	}
	
	/**
	 * Ecrit les donnée ITCP du le tableau des Tags dans le document photo
	 *
	 * @param string
	 * @return mixed
	 */
	public function EcrTag()
	{
	
		$datas = null;
	
		foreach($this->listTags as $tag => $valeur)
		{
			$donnée=null;
			if(is_array ( $valeur ))
			{
				$donnée = implode ( ";" , $valeur );
			}
			else
			{
				$donnée = $valeur ;
			}
				
			$tag = substr($tag, 2);
			$datas .= $this->_transform_iptc($tag, $donnée);
		}
	
		//$this->save($datas,$_ENV['SiteDossier'] . 'X_AppAlbum/vue/sauvegarde.jpg');
		$this->save($datas,$this->getPhoto());

	}

	/**
	 * met en forme les balise ITCP pour l'ecriture dans le document photo
	 *
	 * @param string
	 * @return string
	 */
	private function _transform_iptc($data, $value)
	{
		$length = strlen($value);
		$retval = chr(0x1C).chr(2).chr($data);
		 
		if ($length < 0x8000)
		{
			$retval .= chr($length >> 8).chr($length& 0xFF);
	
	
		}
		else
		{
			$retval .= chr(0x80).chr(0x04).
			chr(($length >> 24)& 0xFF).
			chr(($length >> 16)& 0xFF).
			chr(($length >> 8)& 0xFF).
			chr($length& 0xFF);
	
	
		}
	
		 
		 
		return $retval.$value;
	}
	
	/**
	 * Ecriture et Sauvegarde physique du document photo
	 *
	 * @param string
	 * @return string
	 */
	public function save($datas, $newImageName = '')
	{
		
		$file = $_ENV['SiteDossier'] . 'X_AppAlbum/vue/temps.jpg';
		$fp = fopen($file, "wb");
		$source = imagecreatefromjpeg($this->getPhoto ());
		ImageJpeg($source, $file);
		$data_image = iptcembed($datas, $file);
		
		fwrite($fp, $data_image);
		
		$this->photo = addslashes ( rawurlencode (file_get_contents($file)));
		fclose($fp);
		imagedestroy($source); //détruit l'image, libérant ainsi de la mémoire
		unlink ($file); // supprime le fichier temporaire
		
	}
}


class MyPhoto extends ITCP
{	
	
	/**
	 * Image bulle qui va etre inserré dans l'image "rendu" par la fonction Dessinateur()
	 *
	 * @var string
	 * @access protected
	 */
	protected $bulle;
	/**
	 * Retourne l'image "bulle" prete a etre affiché sur une page
	 *
	 * @param void
	 * @return void
	 */
	public function getBulle()
	{
		return 'data:image/jpg,' .  $this->bulle ;
	}
	/**
	 * assigne l'image "bulle"
	 *
	 * @param void
	 * @return void
	 */
	public function setBulle($value)
	{
		$this->bulle = addslashes ( rawurlencode (file_get_contents ( $value )));
	}
	/**
	 * verifie et assigne la "Bulle" apres un telechargement
	 *
	 * @param string  $value = Variable de téléchargement de fichier via HTTP
	 * @return void
	 */
	public function bulleTelecharge($value)
	{
		$taille_max = 600000;
		$typeMime = 'image/png';
		if ($value['size'] > $taille_max)
		{
			throw new MyException ( "", 0, 'fichier incorecte', 'Ce fichier fait ' . $value['size'] . ' octées', 'Ce fichier ne serra pas enregistré', 'selectionnez un fichier de moins de ' . $taille_max . ' octées' );
		}
		elseif ($value['type'] != $typeMime)
		{
			throw new MyException ( "", 0, 'fichier incorecte', 'Ce fichier est de type ' . $value['type'], 'Ce Prenom ne va pas etre pris en compte', 'selectionnez un fichier est de type ' . $typeMime );
		} else
		{
			$this->bulle = addslashes ( rawurlencode (file_get_contents ($value['tmp_name'])));
		}
	}

	/**
	 * texte  qui va etre ecrit dans l'image "bulle" par la fonction Dessinateur()
	 *
	 * @var string
	 * @access protected
	 */
	protected $texteBulle;
	/**
	 * Retourne le texte de la Bulle
	 *
	 * @param string
	 * @return mixed
	 */
	public function getTexteBulle()
	{
		return $this->texteBulle ;
	}
	/**
	 * assigne le texte Bulle
	 *
	 * @param string $value = le texte qui doit etre ecrit dans la bulle
	 * @return mixed
	 */
	public function setTexteBulle($value)
	{
		$this->texteBulle =  $value ;
	}
	
	/**
	 * Image Resultat des manipulation GD faite par la fonction Dessinateur()
	 *
	 * @var string
	 * @access protected
	 */
	protected $rendu;
	/**
	 * Retourne l'image "rendu" prete a etre affiché sur une page
	 *
	 * @param void
	 * @return void
	 */
	public function getRendu()
	{
		return 'data:image/jpg,' . $this->rendu ;
	}
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * Dessine l'image "rendu"
	 * Integre Dans une photo 
	 * 	-une description en bas
	 *  -une bulle type bande dessiné
	 *
	 * @param void
	 * @return void
	 */
	public function Dessinateur()
	{
		
		$font_fileDescription = 'C:/wamp64\www/site01/appObjet/vue/resource/police/fontDescription.ttf'; // chemin de la police de caractère.
		$font_ColorDescription = "FFFFFF"; // couleur de la police de caractère.
		$font_fileBulle = 'C:/wamp64\www/site01/appObjet/vue/resource/police/font.ttf'; // chemin de la police de caractère.
		$font_ColorDBulle = "000000"; // couleur de la police de caractère.
		
		
		if(!empty ( $this->photo ))
		{
		//1) Infos sur l'image originel
			list($largeur, $hauteur) = getimagesize($this->getPhoto());
			
			//echo "MyPhoto.Dessinateur() largeur: ".$largeur."</br>";
			//echo "MyPhoto.Dessinateur() hauteur: ".$hauteur."</br>";
			
		//2) info sur la description
			$fontBox=$this->TailleCaractere($largeur,$font_fileDescription,$this->__get("Description"));
			
			//echo "MyPhoto.Dessinateur() fontBox largeur: ".$fontBox['largeur']."</br>";
			//echo "MyPhoto.Dessinateur() fontBox hauteur: ".$fontBox['hauteur']."</br>";
			//echo "MyPhoto.Dessinateur() fontBox police: ".$fontBox['font_size']."</br>";
			
		//3) creer l'image support		
			// prendre en compte l'image originel et le texte de la description
			$largeurRendu = $largeur;
			$hauteurRendu = $hauteur + $fontBox['hauteur'] + ($fontBox['hauteur']*0); // ajout de 10 % ?
			
			//echo "MyPhoto.Dessinateur() Rendu largeur: ".$largeurRendu."</br>";
			//echo "MyPhoto.Dessinateur() Rendu hauteur: ".$hauteurRendu."</br>";
			
			$rendu = imagecreatetruecolor($largeurRendu,$hauteurRendu);
			
			
		//4) Inserer l'image originel sur l'image support
			$source = imagecreatefromjpeg($this->getPhoto ());
			imagecopy($rendu,$source,0, 0, 0, 0, $largeur, $hauteur);
			
		
		//5) Inserer La description sur l'image support
			if(!empty ( $this->__get("Description") ))
			{
				$fontCouleurDesc= imagecolorallocate($rendu,hexdec(substr($font_ColorDescription,0,2)),hexdec(substr($font_ColorDescription,2,4)),hexdec(substr($font_ColorDescription,4,6)));
				$posDescX = ($largeurRendu - $fontBox['largeur'])/2 ;
				$posDescY = $hauteurRendu ;
				
				//echo "MyPhoto.Dessinateur() posDescX: ".$posDescX."</br>";
				//echo "MyPhoto.Dessinateur() posDescY: ".$posDescY."</br>";
				
				
				putenv('GDFONTPATH=' . realpath('.')); //ligne obligatoire !
				imagettftext($rendu, $fontBox['font_size'], 0, $posDescX, $posDescY , $fontCouleurDesc, $font_fileDescription, $this->__get("Description"));
			}
			
		//6) Si il y a un texte infobulle creer la bulle
			if(!empty ( $this->bulle ))
			{
				//1) Infos sur l'image originel
				list($largeurBulle, $hauteurBulle) = getimagesize($this->getBulle());
				
				//echo "MyPhoto.Dessinateur() bulle largeur: ".$largeurBulle."</br>";
				//echo "MyPhoto.Dessinateur() bulle hauteur: ".$hauteurBulle."</br>";
				
				//2) info sur le texte bulle
				$fontBoxBulle=$this->TailleCaractere($largeurBulle,$font_fileDescription,$this->__get("Instructions"));
				
				//echo "MyPhoto.Dessinateur() bulle fontBox largeur: ".$fontBoxBulle['largeur']."</br>";
				//echo "MyPhoto.Dessinateur() bulle fontBox hauteur: ".$fontBoxBulle['hauteur']."</br>";
				//echo "MyPhoto.Dessinateur() bulle fontBox police: ".$fontBoxBulle['font_size']."</br>";
				
				//3) creer l'image de la bulle
				$bulle = imagecreatefrompng($this->getBulle ());
				imageAlphaBlending ($bulle, true) ;
				imageSaveAlpha($bulle, true);
				
				//4) inserer le texte infobulle dans la bulle
				$fontCouleurBulle= imagecolorallocate($bulle,hexdec(substr($font_ColorDBulle,0,2)),hexdec(substr($font_ColorDBulle,2,4)),hexdec(substr($font_ColorDBulle,4,6)));
				$posTexteBulleX = ($largeurBulle - $fontBoxBulle['largeur'])/2 ;
				$posTexteBulleY = $hauteurBulle/2 ;
				
				//echo "MyPhoto.Dessinateur() posTexteBulleX: ".$posTexteBulleX."</br>";
				//echo "MyPhoto.Dessinateur() posTexteBulleY: ".$posTexteBulleY."</br>";
				
				putenv('GDFONTPATH=' . realpath('.')); //ligne obligatoire !
				imagettftext($bulle, $fontBoxBulle['font_size'], 0,$posTexteBulleX, $posTexteBulleY, $fontCouleurBulle, $font_fileBulle, $this->__get("Instructions"));
					
				//5) inserer la bulle sur l'image support
				
				// tenir compte de l'orientation
				$PositionBulle = null;
				switch($PositionBulle)
				{
					case "haut-gauche" :
						$posBulleX = 0;
						$posBulleY = 0;
		
					case "haut-centre" :
						$posBulleX = ($largeurRendu - $fontBoxBulle['largeur'])/2 ;
						$posBulleY = 0;
						break;
		
					case "haut-droit" :
						$posBulleX = $largeurRendu - $fontBoxBulle['largeur'] -10 ;
						$posBulleY = 0;
						break;
					case "centre-gauche" :
						$posBulleX = 0;
						$posBulleY = ($hauteurRendu - $fontBoxBulle['hauteur'])/2 ;
						break;
					case "centre-centre" :
						$posBulleX = ($largeurRendu - $fontBoxBulle['largeur'])/2 ;
						$posBulleY = ($hauteurRendu - $fontBoxBulle['hauteur'])/2 ;
						break;
					case "haut-droit" :
						$posBulleX = $largeurRendu - $fontBoxBulle['largeur'] -10 ;
						$posBulleY = ($hauteurRendu - $fontBoxBulle['hauteur'])/2 ;
						break;
					case "bas-gauche" :
						$posBulleX = 0;
						$posBulleY = $hauteurRendu - $fontBoxBulle['hauteur'] -10 ;
						break;
					case "bas-centre" :
						$posBulleX = ($largeurRendu - $fontBoxBulle['largeur'])/2 ;
						$posBulleY = $hauteurRendu - $fontBoxBulle['hauteur'] -10 ;
						break;
					case "bas-droit" :
						$posBulleX = $largeurRendu - $fontBoxBulle['largeur'] -10 ;
						$posBulleY = $hauteurRendu - $fontBoxBulle['hauteur'] -10 ;
						break;						
					default :
						$posBulleX = 0;
						$posBulleY = 0;
						break;
				}
						
				//echo "MyPhoto.Dessinateur() posBulleX: ".$posBulleX."</br>";
				//echo "MyPhoto.Dessinateur() posBulleY: ".$posBulleY."</br>";
				
				imagecopy($rendu,$bulle,$posBulleX, $posBulleY, 0, 0, $largeurBulle, $hauteurBulle);
				
				
				
			}
			
		//7) Crée le fichier
			$file = 'C:\wamp64\www\site01\appObjet\vue\resource\img\rendu().jpg';
			$fp = fopen($file, "x+");
			ImageJpeg($rendu, $file);
			imagedestroy($rendu); //détruit l'image, libérant ainsi de la mémoire
			$F =fread ( $fp,filesize($file) );
			fclose($fp);
			unlink ($file);
			
			$this->rendu = addslashes ( rawurlencode ($F));
		
		}
	}
	
	/**
	 * Permet de determiner la taille de la police d'un texte 
	 * dans une zone dessin déterminé
	 * 
	 *
	 * @param int $tailleImage = Largeur que doit prendre le texte dans l'image
	 * @param string $police = Chemin de la police de caractere utiliser pour dessiner le texte
	 * @param string $texte = Texte qui va etre affiché
	 * @return array $resultat = Tableau contenant la "Largeur", la "Hauteur" et la taille de police(font_size) que prendra le texte . 
	 */
	protected function TailleCaractere($tailleImage,$police,$texte  = null)
	{
		
		if(!empty ( $texte ))
		{
			$font_size = 20;
			$t = imagettfbbox ( $font_size , 0 , $police , $texte );
				
			while($t[4]-$t[6] > ($tailleImage - 10) )
			{
				$font_size--;
				$t = imagettfbbox ( $font_size , 0 , $police , $texte );
			
			}

			$resultat= array(
				'largeur' =>  $t[4]-$t[6],
				'hauteur' => abs($t[0]+$t[7]),
				'font_size' => $font_size
				);
		}
		else 
		{
			$resultat= array(
					'largeur' => 0,
					'hauteur' => 0,
					'font_size' => 0
			);
		}
		
		return $resultat;
	}
	
	
	

}