<?php
namespace appAlbum\modele;

class iptc implements \ArrayAccess
{
 
    protected $chemin = null;
    protected $info =null;
    protected $dictionnaireIpct = array(
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
    protected $ListeITPC =[];
    //protected $info = null;
    
    public function getITCP($clé)
    {
        if( isset ($this->ListeITPC[$this->getDictionnaireIpct($clé)][0]) )
        {
           
            return $this->ListeITPC[$this->dictionnaireIpct[$clé]][0];
        }
    
       return "";
        
    }
    
    public function setITCP($clé, $valeur)
    {
        if( isset ($this->ListeITPC[$this->dictionnaireIpct[$clé]][0]) )
        {
            $this->ListeITPC[$this->dictionnaireIpct[$clé]][0] = $valeur;
        }
        else 
        {            
            $this->ListeITPC[$this->dictionnaireIpct[$clé]][] =$valeur;
        }
    }
    
    public function getDictionnaireIpct($clé)
    {
        if( isset ($this->dictionnaireIpct[$clé] ) )
        {
            return $this->dictionnaireIpct[$clé];
        }
        
        return "";
    }
    
    public function __construct($chemin = null)
    {
        
        
        $this->chemin = $chemin;
        $this->chargerIptc();
        /*
        $this->dictionnaireIpct = array(
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
        */
        
        
        return $this;
    }
    
    protected function chargerIptc()
    {
        
        
        GetImageSize ($this->chemin,$this->info);        
        if(isset($this->info["APP13"]))
        {
            $this->ListeITPC = iptcparse ($this->info["APP13"]);          
        }
    
    }
    
    public function sauvegarderIptc()
    {
        $iptc_data = null;        
        foreach ($this->ListeITPC as $clé => $valeur)
        {
            $clé = substr($clé, 2); #3
            $iptc_data .= $this->transformer_iptc($clé, $valeur[0]); #
        }
        
        $donnees = iptcembed($iptc_data, $this->chemin);
        $fichier = fopen($this->chemin, "wb"); # Ouverture du fichier
        fwrite($fichier, $donnees); # Écriture du fichier
        fclose($fichier); # Fermeture du fichier
    }
    
    protected function transformer_iptc($data, $value)
    {
        
        $length = strlen($value);
        $retval = chr(0x1C).chr(2).chr($data);
        
        if($length < 0x8000)
            $retval .= chr($length >> 8).chr($length& 0xFF);
            else{
                $retval .= chr(0x80).chr(0x04).
                chr(($length >> 24)& 0xFF).
                chr(($length >> 16)& 0xFF).
                chr(($length >> 8)& 0xFF).
                chr($length& 0xFF);
            }
            return $retval.$value;
    }
        
    public function lire()
    {
        foreach ($this->dictionnaireIpct as $clé => $valeur)
        {
            if($this->getITCP($clé)!="")
                echo "{$clé} ({$valeur}): <b>{$this[$clé]}</b></br>";
        }
        
    }
        
    public function offsetExists($offset)
    {       
        return array_key_exists($this->dictionnaireIpct[$offset],$this->ListeITPC);
    }
    public function offsetGet($offset)
    {
        
        return $this->getITCP($offset);
    }
    public function offsetSet($offset, $value)
    {
        $this->setITCP($offset, $value);
    }    
    public function offsetUnset($offset)
    {        
        if($this->offsetExists($offset))
        {
            unset($this->ListeITPC[$offset]);
        }
    }
    
}

