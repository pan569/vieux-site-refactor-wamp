<?php
namespace appObjet\modele;

/**
*
*/
class MyIptc
{
    public $file     = '';
    
    /**
     * Tableau des données ITCP du document photo
     *
     * @var array
     * @access protected
     */
    public $listTags = array();
    
    /**
     * Recupere la donnée ITCP du document photo et la met dans le tableau
     *
     * @param string
	 * 
     */
    public function getTag($tag)
    {
    	$size = getimagesize($this->file, $info);
    	$iptc = iptcparse($info['APP13']);
    
    	if(array_key_exists ($tag, $iptc ))
    	{
    		$this->listTags[$tag] = $iptc[$tag];
    
    	}
    
    }
    
    
    /**
     * Assigne une valeur a un tag donnée dans le tableau de données des tags
     *
     * @param string
     * 
     */
    public function setTag($tag,$value)
    {
    	$this->listTags[$tag] = $value;
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
    
   
	public function __construct($filename)
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
    	
    	
    	foreach($this->dictionnaire as $valeur )
    	{
    	    $this->listTags[$valeur]="";
    	}
		
		if (!empty($filename) && is_file($filename))
			$this->file = $filename;
		
	}
	
	
	/**
	 * Assigne une valeur a un tag donnée dans le tableau de données des tags
	 *
	 * @param string
	 * 
	 */
	public function getNom($value)
	{
		if( array_key_exists ( $value , $this->catalogue ))
		{
			$this->getTag($this->catalogue[$value]);
		}
	}
	
	
	/**
	 * récupere toute les données ITCP du document Photo dans le tableau de données des tags
	 *
	 * @param void
	 * 
	 */
	public function get()
	{
		$t = array_keys ( $this->catalogue );
		foreach($t as $valeur)
		{
			$this->getNom($valeur);
		}
		
	}
	

	/**
	 * Ecrit toute les données ITCP du tableau de données des tags
	 * et sauvegarde l'image
	 *
	 * @param void
	 * 
	 */
	public function addMultiple()
	{
		
		$datas = null;
		
		foreach($this->listTags as $tag => $valeur) 
		{
			$donnée= null;
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
		
		$this->save($datas,$_ENV['SiteDossier'] . 'X_AppAlbum/vue/sauvegarde.jpg');
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
    	
    	
    	
    	if (!empty($newImageName))
    		$imageName = $newImageName;
    	else
    		$imageName = $this->file;
    	
    	
    
    	// Writing datas in the image
    	$data_image = iptcembed($datas, $this->file);
    
    	$fp = fopen($imageName, "wb");
    
    	fwrite($fp, $data_image);
    	fclose($fp);
    }

}
