<?php

foreach ($model->getPhotos() as $i)
{
    //debug($i->getimageNomAlbum(),'Album.php ligne 5 item NomAlbum');
    //debug($i->getimageNomPhoto(),'Album.php ligne 6 item NomPhoto');
    //debug($this->routeur->getRoute('visualiserPhoto')->generateUri(['nomAlbum' => $i->getimageNomAlbum(), 'nomPhoto' => $i->getimageNomPhoto()]),'Album.php ligne 7 url item');
    //debug($model);
};

//$url=$urlAlbums.$nomAlbum."/";
//$a = $this->routeur->getRoute('visualiserPhoto')->generateUri(['nomAlbum' => $item->getimageNomAlbum(), 'nomPhoto' => $item->getimageNomPhoto()]);
//debug($a,'Album.php L9 a');$item->getimageNomPhoto()])
?>

<h1>Album</h1>
<div><a href="<?= $this->routeur->getRoute('tester')->generateUri();?> ">test</a></div>
<div >
<?php foreach ( $model->getPhotos() as $item): ?>
	<div style="display: inline;">
	<?php 
        //debug($item);
        //debug($item->getimageNomAlbum(),"nom album");
        //debug($item->getimageNomPhoto(),"nom photo");
       
	?>
	
	
		<a href="<?= $this->routeur->getRoute('visualiserPhoto')->generateUri(['nomAlbum' => $item->getimageNomAlbum(), 'nomPhoto' => $item->getimageNomPhoto()]);?> "> 
			<img src="<?=$item->getImageUrl() ?>" alt="<?=$item->getimageNomPhoto() ?>" height="150" /> 
		</a>    	
	</div>
<?php endforeach;?>    
</div>			
			
<!--  			
			<a class="x1i10hfl xjbqb8w x6umtig x1b1mbwd xaqea5y xav7gou x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1heor9g xt0b8zv" href="/photo/?fbid=10217866372185171&amp;set=a.10217866361664908" role="link" tabindex="0">
				<img class="x1rg5ohu x5yr21d xl1xv1r xh8yej3" src="https://scontent.frns1-1.fna.fbcdn.net/v/t1.6435-9/67128373_10217866372225172_3102007333165727744_n.jpg?stp=dst-jpg_s552x414&amp;_nc_cat=104&amp;ccb=1-7&amp;_nc_sid=cdbe9c&amp;_nc_ohc=GWZaQzgX7cMAX9C__3s&amp;_nc_ht=scontent.frns1-1.fna&amp;oh=00_AfBp3NANLy1Ci2elE-hZTHrntMejMI-49UuEUBRSuGw5xA&amp;oe=65123B5B" alt="Aucune description de photo disponible.">
				<div class="xzg4506 xycxndf xua58t2 x4xrfw5 x1ey2m1c x9f619 xds687c x10l6tqk x17qophe x13vifvy"></div>
				<div class="x1923su1 x10l6tqk xfr5jun">
					<div aria-expanded="false" aria-haspopup="menu" aria-label="Modifier" class="x1i10hfl x6umtig x1b1mbwd xaqea5y xav7gou x1ypdohk xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r x16tdsg8 x1hl2dhg xggy1nq x87ps6o x1lku1pv x1a2a7pz x6s0dn4 x14yjl9h xudhj91 x18nykt9 xww2gxu x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x78zum5 xl56j7k xexx8yu x4uap5 x18d9i69 xkhd6sd x1n2onr6 x10w6t97 x1td3qas x18l40ae x14ctfv" role="button" tabindex="0">
						<i data-visualcompletion="css-img" class="x1b0d499 xaj1gnb" style="background-image: url(&quot;https://static.xx.fbcdn.net/rsrc.php/v3/yY/r/ce_f8bO6C6k.png&quot;); background-position: 0px -359px; background-size: auto; width: 16px; height: 16px; background-repeat: no-repeat; display: inline-block;"></i>
						<div class="x1ey2m1c xds687c xg01cxk x47corl x10l6tqk x17qophe x13vifvy x1ebt8du x19991ni x1dhq9h x14yjl9h xudhj91 x18nykt9 xww2gxu" data-visualcompletion="ignore"></div>
					</div>
				</div>
			</a>
-->