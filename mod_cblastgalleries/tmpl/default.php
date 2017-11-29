<?php
/**
 * @package Module CB Last Galleries for Joomla! 3.x
 * @version $Id: mod_cblastgalleries.php 2015-04-09 12:18:00Z 
 * @author Hector Vega
 * @copyright  Copyright (C) 2015 Hector Vega, Systemas HV, All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
**/
defined('_JEXEC') or die;

//JHtml::_( 'behavior.keepalive' );

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Galleries from CB</title>
</head>
<body>
   <link rel="stylesheet" type="text/css" media="all" href="/modules/mod_cblastgalleries/assets/css/font-awesome.min.css" />
   <link rel="stylesheet" type="text/css" media="all" href="/modules/mod_cblastgalleries/assets/css/jgallery.min.css?v=1.5.5" />
   <link rel="stylesheet" type="text/css" media="all" href="/modules/mod_cblastgalleries/assets/css/jgallery.css" />

   
<div id="gallery">
   <?php
   
      foreach ($rows as $row)
     {
       if(!empty($rows)){GetImages($row->id,$usingcbgallery,$row->username);};
     };
   
   ?>
</div>
  
 
<script type="text/javascript" src="./modules/mod_cblastgalleries/assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="./modules/mod_cblastgalleries/assets/js/jgallery.min.js?v=1.5.5"></script>
<script type="text/javascript" src="./modules/mod_cblastgalleries/assets/js/touchswipe.min.js"></script>
<script type="text/javascript" src="./modules/mod_cblastgalleries/assets/js/tinycolor-0.9.16.min.js"></script>



<script type="text/javascript">

       $( function(){
        $( "#gallery" ).jGallery( {
            height: '80vh',
            preloadAll: false,
            slideshowAutostart: <?php echo "'". $slideshowAutostart."',"; ?>
            title: <?php echo "'".$title."',"; ?>
            thumbnailsPosition:<?php echo "'". $thumbnailsPosition."',"; ?>
            backgroundColor: <?php echo "'". $backgroundColor."',"; ?>
            textColor: <?php echo "'". $textColor."',"; ?>
            mode: <?php echo "'". $mode."',"; ?>
            zoomSize: <?php echo "'". $zoomSize."'"; ?>
        } );
    } );        
          
          
       
  

</script>
   
<?php
   
    if($poweredbysistemashv == 'Yes'){
            Echo '<p style="text-align: Center">Powered by <a href="http://www.sistemashv.com">Sistemas HV</a></p>';
       };

?>
</body>