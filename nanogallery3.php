<?php
/*
Plugin Name: nanoGallery
Description: Touch enabled and responsive image gallery. It supports pulling in Flickr, Picasa and Google+ photo albums.
Version: 4.4.2
Author: Christophe Brisbois
Author URI: http://www.brisbois.fr/
*/

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");
$nanoGallery_debugmode=false;

# register plugin
register_plugin(
	$thisfile, 						      //Plugin id
	'nanoGallery', 					    //Plugin name
	'4.4.2', 						        //Plugin version
	'Christophe Brisbois',  		//Plugin author
	'http://nanogallery4gs.brisbois.fr/', 		//author website
	'<b>Touch enabled and responsive image gallery.</b><br> It supports pulling in Flickr, Picasa and Google+ photo albums.', //Plugin description
	'pages', 						        //page type - on which admin tab to display
	'nanoGallery_show'  			  //main function (administration)
);
 
# activate filter 
add_filter('content','nanoGallery'); 
add_action('index-pretemplate','nanoGallery_check'); 
queue_script('jquery', GSFRONT);

class nanoGallerySettings {
	var $_kind='picasa';
  var $_userID='';
	var $_thumbnailLabelPosition='';	//'overImageOnBottom';
	var $_displayCaption=false;
	var $_displayDescription=false;
	var $_thumbnailHoverEffect='';
	var $_viewer='';
	var $_colorScheme='';
	var $_colorSchemeViewer='';
	var $_thumbnailHeight;
	var $_thumbnailWidth;
	var $_blackList;
	var $_whiteList;
	var $_forceJQuery=false;
	var $_consistencyError='';
	var $_theme='default';
	var $_displayBreadcrumb=true;
	var $_album='';
	var $_photoset='';
	var $_maxItemsPerLine=0;
	var $_maxWidth=0;

	// check the consistency of the parameters
	public function checkConsistency() {
		//return true;
		
		if( empty($this->_kind) OR ($this->_kind != 'picasa' AND $this->_kind != 'flickr' AND $this->_kind != 'getsimple') ) {
			$this->_consistencyError='Incorrect parameters for nanoGallery. Please define the "kind". Possible values : "flickr", "picasa" - '.$this->_kind;
			return false;
		}

		//if( $this->_kind == 'picasa' AND !empty($this->_userID)  ) {
		//	return true;
		//}

		
		if( !empty($this->_userID)  ) {
			return true;
		}

//		if( $this->_stringFound ) {
//			$this->_consistencyError='Incorrect parameters for nanoGallery. Please check the settings in your page.';
//			return false;
//		}
		$this->_consistencyError='Incorrect parameters for nanoGallery. Please check the settings in your page.';
		return false;
		
	}

	
	// build the parameter string to pass to the javascript
	public function jsParams() {
		global $SITEURL;
		$s="{";
		if( !empty($this->_userID) ) { $s.="userID:'".$this->_userID."',"; } 

    
    $d="";
		//if( !empty($this->_displayCaption) ) { $s.="'displayCaption':".$this->_displayCaption.","; }
		if( !empty($this->_displayCaption) ) { $d.="display:".$this->_displayCaption.","; }
		if( !empty($this->_displayDescription) ) { $d.="displayDescription:".$this->_displayDescription.","; }

		if( !empty($this->_thumbnailLabelPosition) ) {
      $d.="position:'".$this->_thumbnailLabelPosition."',";
			// if( !empty($this->_displayCaption) ) {
				// $s.="'thumbnailLabel':{'position':'".$this->_thumbnailLabelPosition."','display':".$this->_displayCaption."},";
			// }
			// else {
				// $s.="'thumbnailLabel':{'position':'".$this->_thumbnailLabelPosition."'},";
			// }
		}
		// else {
			// if( !empty($this->_displayCaption) ) {
				// $s.="'thumbnailLabel':{'display':".$this->_displayCaption."},";
			// }
		// }
    
    if( !empty($d) ) {
      $d=substr($d,0,strlen($d)-1);
      $s.="'thumbnailLabel':{".$d."},";
    }

		if( !empty($this->_thumbnailHoverEffect) ) { $s.="'thumbnailHoverEffect':'".$this->_thumbnailHoverEffect."',"; } 
		if( !empty($this->_viewer) ) { $s.="'viewer':'".$this->_viewer."',"; } 
		if( !empty($this->_colorScheme) ) { $s.="'colorScheme':'".$this->_colorScheme."',"; } 
		if( !empty($this->_colorSchemeViewer) ) { $s.="'colorSchemeViewer':'".$this->_colorSchemeViewer."',"; } 
		// if( !empty($this->_thumbnailHeight) ) { $s.="'thumbnailHeight':'".$this->_thumbnailHeight."',"; } 
		if( !empty($this->_thumbnailHeight) ) {
      if( $this->_thumbnailHeight == 'auto' ) {
        $s.="'thumbnailHeight':'".$this->_thumbnailHeight."',";
      }
      else {
        $s.="'thumbnailHeight':".$this->_thumbnailHeight.",";
      }
    }
		if( !empty($this->_thumbnailWidth) ) {
      if( $this->_thumbnailWidth == 'auto' ) {
        $s.="'thumbnailWidth':'".$this->_thumbnailWidth."',";
      }
      else {
        $s.="'thumbnailWidth':".$this->_thumbnailWidth.",";
      }
    } 
		if( !empty($this->_blackList) ) { $s.="'blackList':'".$this->_blackList."',"; } 
		if( !empty($this->_whiteList) ) { $s.="'whiteList':'".$this->_whiteList."',"; } 
		if( !empty($this->_kind) ) { $s.="'kind':'".$this->_kind."',"; } 
		if( !empty($this->_theme) ) { $s.="'theme':'".$this->_theme."',"; } 
		if( !empty($this->_displayBreadcrumb) ) { $s.="'displayBreadcrumb':".$this->_displayBreadcrumb.","; } 
		if( !empty($this->_album) ) { $s.="'album':'".$this->_album."',"; } 
		if( !empty($this->_photoset) ) { $s.="'photoset':'".$this->_photoset."',"; } 
		if( !empty($this->_maxItemsPerLine) ) { $s.="'maxItemsPerLine':'".$this->_maxItemsPerLine."',"; } 
		if( !empty($this->_maxWidth) ) { $s.="'maxWidth':'".$this->_maxWidth."',"; } 
		
		if ( strlen($s) == 1 ) { return ""; }
		
		$s.="'pluginURL':'".$SITEURL."/plugins/nanogallery3',";
		
		$s=substr($s,0,strlen($s)-1)."}";
		return $s;
	}
}

class nanoGalleryParsedContent {
	var $_nanoGallerySettings;
	var $_newContent='';
	
	function __construct($content) {
		$this->_nanoGallerySettings=array();
		$this->_newContent=$content;
		$ok=true;
		do{
			$ok=$this->parseContent();
		} while( $ok );
	}
	
	function parseContent() {
		$p1 = strpos($this->_newContent, '(%nanogallery');
		if ( $p1 === false ){  return false; };
		$p2= strpos($this->_newContent, '%)', $p1+2);
		if ( $p2 === false ){  return false; };

		$n=count($this->_nanoGallerySettings);
		$this->_nanoGallerySettings[$n]=new nanoGallerySettings();
		//$tmp=strtolower(substr($this->_newContent, $p1+13, $p2-$p1-13));
		$tmp=substr($this->_newContent, $p1+13, $p2-$p1-13);
		// replace the settings with the DIV container in the page
		//$this->_newContent=substr($this->_newContent,0,$p1)."<div id='nanoGallery".$n."' class='nanoGallery'></div>".substr($this->_newContent,$p2+2);
		$this->_newContent=substr($this->_newContent,0,$p1)."<div id='nanoGallery".$n."' ></div>".substr($this->_newContent,$p2+2);

		$tmp=html_entity_decode($tmp);
		$tmp=str_replace('<p>','',$tmp);
		$tmp=str_replace('</p>','',$tmp);
		$tmp=str_replace('&nbsp;','',$tmp);
		$tmp=str_replace('&amp;','&',$tmp);
		$tmp=str_replace('<br>','',$tmp);
		$tmp=str_replace('<br />','',$tmp);
		$tmp=str_replace(' ','',$tmp);
		$tmp=str_replace('\"','"',$tmp);
		$tmp=str_replace(array("\t", "\n", "\r"),'',$tmp);
		parse_str($tmp,$fields);

		
		// get parameters value
		if( isset($fields['userID']) ) { $this->_nanoGallerySettings[$n]->_userID=$fields['userID']; }
		if( isset($fields['displayCaption']) ) { $this->_nanoGallerySettings[$n]->_displayCaption=$fields['displayCaption']; }
		if( isset($fields['displayDescription']) ) { $this->_nanoGallerySettings[$n]->_displayDescription=$fields['displayDescription']; }
		if( isset($fields['thumbnailLabelPosition']) ) { $this->_nanoGallerySettings[$n]->_thumbnailLabelPosition=$fields['thumbnailLabelPosition']; }
		if( isset($fields['thumbnailHoverEffect']) ) { $this->_nanoGallerySettings[$n]->_thumbnailHoverEffect=$fields['thumbnailHoverEffect']; }
		if( isset($fields['viewer']) ) { $this->_nanoGallerySettings[$n]->_viewer=$fields['viewer']; }
		if( isset($fields['colorScheme']) ) { $this->_nanoGallerySettings[$n]->_colorScheme=$fields['colorScheme']; }
		if( isset($fields['colorSchemeViewer']) ) { $this->_nanoGallerySettings[$n]->_colorSchemeViewer=$fields['colorSchemeViewer']; }
		if( isset($fields['thumbnailWidth']) ) { $this->_nanoGallerySettings[$n]->_thumbnailWidth=$fields['thumbnailWidth']; }
		if( isset($fields['thumbnailHeight']) ) { $this->_nanoGallerySettings[$n]->_thumbnailHeight=$fields['thumbnailHeight']; }
		if( isset($fields['whiteList']) ) { $this->_nanoGallerySettings[$n]->_whiteList=$fields['whiteList']; }
		if( isset($fields['blackList']) ) { $this->_nanoGallerySettings[$n]->_blackList=$fields['blackList']; }
		if( isset($fields['kind']) ) { $this->_nanoGallerySettings[$n]->_kind=$fields['kind']; }
		if( isset($fields['theme']) ) { $this->_nanoGallerySettings[$n]->_theme=$fields['theme']; }
		if( isset($fields['displayBreadcrumb']) ) { $this->_nanoGallerySettings[$n]->_displayBreadcrumb=$fields['displayBreadcrumb']; }
		if( isset($fields['album']) ) { $this->_nanoGallerySettings[$n]->_album=$fields['album']; }
		if( isset($fields['photoset']) ) { $this->_nanoGallerySettings[$n]->_photoset=$fields['photoset']; }
		if( isset($fields['maxItemsPerLine']) ) { $this->_nanoGallerySettings[$n]->_maxItemsPerLine=$fields['maxItemsPerLine']; }
		if( isset($fields['maxWidth']) ) { $this->_nanoGallerySettings[$n]->_maxWidth=$fields['maxWidth']; }
		if( isset($fields['forceJQuery']) ) { 
			if( $fields['forceJQuery'] == 'true' ) { $this->_sliders[$n]->_forceJQuery=$fields['forceJQuery']; }
		}

		return true;
	}

}


function nanoGallery_check() {
    global $data_index;	
	global $nanoGallery_debugmode;

	if( file_exists(getcwd().'/plugins/nanogallery3_debug.on') ) {
		$nanoGallery_debugmode=true;
		nanoGallery_debug('debug mode is on');
	}

	if (strpos($data_index->content, '(%nanogallery') === false ){
		nanoGallery_debug('(%nanogallery not detected');
		return false;
	};
	add_action('theme-header','nanoGallery_header');
};

function nanoGallery_header() {
    
    global $data_index;	
	global $SITEURL;

	nanoGallery_debug('nanoGallery_header start');

	
	if (strpos($data_index->content, '(%nanogallery') === false ){  return false; };
	$mp = new nanoGalleryParsedContent($data_index->content);
	nanoGallery_debug('count: '.count($mp->_nanoGallerySettings));
	
    $tmpContent='<meta name="generator" content="GetSimple nanoGALLERY">'."\n";

    $tmpContent.='<link href="'.$SITEURL.'/plugins/nanogallery3/js/css/nanogallery.css" rel="stylesheet" type="text/css">'."\n";
	for( $i=0; $i<count($mp->_nanoGallerySettings); $i++ ) {
		if( strlen($mp->_nanoGallerySettings[$i]->_theme) > 0 and $mp->_nanoGallerySettings[$i]->_theme != 'default' ) {
			$tmpContent.='<link href="'.$SITEURL.'/plugins/nanogallery3/js/css/themes/'.$mp->_nanoGallerySettings[$i]->_theme.'/nanogallery_'.$mp->_nanoGallerySettings[$i]->_theme.'.css" rel="stylesheet" type="text/css">'."\n";
		}
	}

	for( $i=0; $i<count($mp->_nanoGallerySettings); $i++ ) {
		if( $mp->_nanoGallerySettings[$i]->_forceJQuery == true ) {
			$tmpContent.='<script type="text/javascript" src="'.$SITEURL.'/plugins/nanogallery3/js/third.party/jquery-1.8.2.min"></script>'."\n";
			break;
		}
	}
    //$tmpContent.='<script type="text/javascript" src="'.$SITEURL.'/plugins/nanogallery3/js/third.party/jquery-jsonp/jquery.jsonp.js"></script>'."\n";
    $tmpContent.='<script type="text/javascript" src="'.$SITEURL.'/plugins/nanogallery3/js/third.party/transit/jquery.transit.min.js"></script>'."\n";
    $tmpContent.='<script type="text/javascript" src="'.$SITEURL.'/plugins/nanogallery3/js/third.party/imagesloaded/imagesloaded.pkgd.min.js"></script>'."\n";
    $tmpContent.='<script type="text/javascript" src="'.$SITEURL.'/plugins/nanogallery3/js/jquery.nanogallery.min.js"></script>'."\n";
	

	for( $i=0; $i<count($mp->_nanoGallerySettings); $i++ ) {
		if( $mp->_nanoGallerySettings[$i]->_viewer == 'fancybox' ) {
			$tmpContent.='<link type="text/css" href="'.$SITEURL.'/plugins/nanogallery3/js/third.party/fancybox/jquery.fancybox.css?v=2.1.4" rel="stylesheet">'."\n";
			$tmpContent.="<script type='text/javascript' src='".$SITEURL."/plugins/nanogallery3/js/third.party/fancybox/jquery.fancybox.pack.js?v=2.1.4'></script>"."\n";
			
			$tmpContent.='<link type="text/css" href="'.$SITEURL.'/plugins/nanogallery3/js/third.party/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" rel="stylesheet">'."\n";
			$tmpContent.="<script type='text/javascript' src='".$SITEURL."/plugins/nanogallery3/js/third.party/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>"."\n";
			$tmpContent.="<script type='text/javascript' src='".$SITEURL."/plugins/nanogallery3/js/third.party/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'></script>"."\n";
			break;
		}
	}


    $tmpContent.='<script>'."\n";
    $tmpContent.='  jQuery(document).ready(function () {'."\n";
	for( $i=0; $i<count($mp->_nanoGallerySettings); $i++ ) {
		//$tmpContent.="    var nanoGALLERY_obj".$i." = new nanoGALLERY();"."\n";
		//$tmpContent.="    nanoGALLERY_obj".$i.".Initiate('nanoGallery".$i."',".$mp->_nanoGallerySettings[$i]->jsParams().",".$i.",'".urlencode($SITEURL."/plugins/nanogallery3")."');"."\n";
		//$tmpContent.="    nanoGALLERY_obj".$i.".Initiate('nanoGallery".$i."',".$mp->_nanoGallerySettings[$i]->jsParams().",".$i.");"."\n";
		$tmpContent.="    jQuery('#nanoGallery".$i."').nanoGallery(".$mp->_nanoGallerySettings[$i]->jsParams().");"."\n";
	}
    $tmpContent.='  });'."\n";
    $tmpContent.='</script>'."\n";
	
    
    echo $tmpContent;
};

# functions
function nanoGallery($content) {

	if (strpos($content, '(%nanogallery') === false ){  return $content; };
	$mp = new nanoGalleryParsedContent($content);
	for( $i=0; $i<count($mp->_nanoGallerySettings); $i++ ) {
		if( $mp->_nanoGallerySettings[$i]->checkConsistency() === false ) {
			return $mp->_nanoGallerySettings[$i]->_consistencyError;
		}
	}

	return $mp->_newContent;

}

function nanoGallery_show() {
	#echo '<p>I like to echo "Hello World" in the footers of all themes.</p>';
}

function nanoGallery_debug($content) {
	global $nanoGallery_debugmode;
	
	if( $nanoGallery_debugmode ) {
		echo 'NANOGALLERY_DEBUG: '.$content.'<br>';
	}
}


?>
