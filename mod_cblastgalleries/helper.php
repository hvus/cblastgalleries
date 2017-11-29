<?php
/**
 * @package Module CB Last Galleries for Joomla! 3.x
 * @version $Id: mod_cblastgalleries.php 2015-04-09 12:18:00Z 
 * @author Hector Vega
 * @copyright  Copyright (C) 2015 Hector Vega, Systemas HV, All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
**/

defined( '_JEXEC' ) or die;

// Check if CB is installed...
$using_cbgallery = "No";

/* Add database instance  */
$db0 = JFactory::getDBO();
$db0->setQuery("SELECT element FROM #__extensions WHERE element = 'com_comprofiler' and enabled=1");
$is_enabled_cb = $db0->loadResult();

if($is_enabled_cb != 'com_comprofiler' ){
  echo 'Sorry, Community Builder is not installed.<br />Please go to Joomlapolis.com and download CB Component and install it...';
  return;
}
else
{
    
    
// Check version of CB gallery installed... (Default old...)
   $db1 = JFactory::getDBO(); 
   $db1->setQuery("SELECT element FROM  #__comprofiler_plugin where (element = 'cbgallery'  or element = 'cb.profilegallery') and published = 1");
   $usingcbgallery = $db1->loadResult();
   // cb.profilegallery --> Old Version
   // cbgallery         --> New Version
   if( $usingcbgallery == 'cbgallery' or  $usingcbgallery == 'cb.profilegallery' ){$using_cbgallery = $usingcbgallery; } 
   else {
       echo 'You have not installed any version of CB Galleries.. please go to Joomlapolis.com and install the plugin.';
       echo '\n'.$usingcbgallery;
       return;
   };
};

 
/*  Get all the Parameter's Settings...   */
$max_profiles_galleries = $params->get("max_profiles_galleries",'20');
$slideshowAutostart = $params->get("slideshowAutostart",'true');
$title = $params->get("title",'true');
$thumbnailsPosition = $params->get("thumbnailsPosition",'bottom'); 
$backgroundColor = $params->get("backgroundColor",'black');
$textColor = $params->get("textColor",'white');
$mode = $params->get("mode",'standard');
$zoomSize = $params->get("zoomSize",'original');
$poweredbysistemashv = $params->get('poweredbysistemashv','Yes');
 
$allfields = "";
 


/*  Get Field's names to put on queries... */
 /*
$cb_field1 = $params->get('cb_field1',"cb_");
$cb_field2 = $params->get('cb_field2',"cb_");
$cb_field3 = $params->get('cb_field3',"cb_");
$cb_filter = $params->get('cb_filterbyfield',"cb_");

// Verify existense of the fields on CB and construct where clause for fields from cb...
$allfields = "";
if(CheckFieldExistOnCB($cb_field1)==0){ $allfields .= ", " .$cb_field1." as Field1"; };
if(CheckFieldExistOnCB($cb_field2)==0){ $allfields .= ", " .$cb_field2." as Field2"; };
if(CheckFieldExistOnCB($cb_field3)==0){ $allfields .= ", " .$cb_field3." as Field3"; };
if(CheckFieldExistOnCB($cb_filter)==0){ $allfields .= ", " .$cb_filter." as Filter"; };
*/
// Set the queries...

/* Add database instance  */
    $db = JFactory::getDBO();

    if($usingcbgallery ==  'cb.profilegallery'){
           $query = "SELECT  distinct c.cb_pgtotalitems,u.username, u.id, c.avatar ".$allfields." 
                     FROM    (
                               Select distinct aa.pgitemdate,aa.userid
                               from  #__comprofiler_plug_profilegallery as aa
                               where aa.pgitempublished = 1 
                               order by aa.pgitemdate desc
                               LIMIT  ".$max_profiles_galleries."
                             ) q
                     JOIN  #__comprofiler c ON (q.userid = c.user_id)
                     JOIN  #__users as u ON (q.Userid = u.id)
                     WHERE u.block =0 AND c.banned = 0 AND c.confirmed = 1 AND c.approved =1 
                     ORDER BY pgitemdate desc
                     LIMIT ".$max_profiles_galleries;
    }
    else {
     if($usingcbgallery == 'cbgallery'){   
           $query = "SELECT  distinct u.username, u.id, c.avatar  ".$allfields." 
                  FROM    (
                            Select distinct aa.user_id,date(aa.date) as date
                            from  #__comprofiler_plugin_gallery_items as aa
                            where aa.published = 1 and aa.type = 'photos' 
                            order by date(aa.date) desc
                            LIMIT  ".$max_profiles_galleries."
                          ) q
                  JOIN  #__comprofiler c ON (q.user_id = c.user_id)
                  JOIN  #__users as u ON (q.User_id = u.id)
                  WHERE u.block =0 AND c.banned = 0 AND c.confirmed = 1 AND c.approved =1                    
                  ORDER BY q.date desc
                  LIMIT ".$max_profiles_galleries;

     }        
    };    

$db->setQuery($query);
$rows = $db->loadObjectList();

/*
$prefix = '';
$ids = '';
foreach ($rows as $row)
{
    if(CountImages($row->id,$usingcbgallery)>0){    
    $ids .= $prefix . '"sliderh' . $row->id . '_container"';
    $prefix = ', ';
    };
};
*/  
//---------------------------------------------------------------------------------------------------------------------
//  Function to pick Images on the galleries and number of pics
//---------------------------------------------------------------------------------------------------------------------

Function GetImages($UserId,$galleryused,$name)
{		
        $db4 = JFactory::getDBO();

        if($galleryused ==  'cbgallery'){
        $query1 = "SELECT Value, Title, Description, folder, id
                   FROM #__comprofiler_plugin_gallery_items as a
                   WHERE a.user_id = ".$UserId." and a.published = 1 and a.type = 'photos'
                   ORDER BY date desc
                   LIMIT 10";
         } else
        {
          $query1 = "SELECT a.pgitemfilename as Value,a.pgitemtitle as Title,a.pgitemdescription as Description, '' as folder
                     FROM  #__comprofiler_plug_profilegallery as a
                     WHERE a.userid = ".$UserId." and a.pgitempublished = 1 and a.pgitemapproved = 1"; 
        };
      
        $db4->setQuery($query1);
        $rows1 = $db4->loadObjectList();
        
        echo '<div class="album" data-jgallery-album-title="Album '.$name.'">';
        
        foreach ($rows1 as $row1){
                        //$thumb = "tn".$row1->Value;

                        $image = $row1->Value;
                        $title = $row1->Title;
                        if($galleryused ==  'cbgallery'){
                             $link_image =  JURI::base() . "index.php?option=com_comprofiler&view=pluginclass&plugin=cbgallery&action=items&func=show&type=photos&id=".
                             $row1->id."&user=".$UserId;  
                        } else
                        {
                           $link_image =  JURI::base() . "images/comprofiler/plug_profilegallery/".$UserId."/".$image;
                        };
                        
                       echo '<a href="'.$link_image.'"><img src="'.$link_image.'" alt="'.$row1->description.'" /></a>';
                        
                      };
        echo '</div>' ;
 

};

  Function CountImages($UserId,$galleryused){

     $db5 = JFactory::getDBO();
     if($galleryused ==  'cbgallery'){

     $sql = "SELECT Count(*) 
             FROM #__comprofiler_plugin_gallery_items as a
             WHERE a.user_id = ".$UserId." and a.published = 1 and a.type = 'photos'";
    } else
    {
      $sql = "SELECT Count(*) 
              FROM #__comprofiler_plug_profilegallery as a
              WHERE a.userid = ".$UserId." and a.pgitempublished = 1 and a.pgitemapproved = 1";
    };

     $db5->setQuery($sql);
     $value = $db5->loadResult();

     Return $value;
};    		


//  Function to check if fieldname on paramaters exist on CB

Function CheckFieldExistOnCB($FieldName)
{
    $Value = 1;

    if(mb_strlen($FieldName,'UTF-8')>3){
 
      $db3 = JFactory::getDBO();
      $db3->setQuery("SELECT name FROM #__comprofiler_fields WHERE name = '".$FieldName."'");
      $exist_field = $db3->loadResult();
      if($exist_field != $FieldName ){
          echo 'Sorry, Community Builder has not the field name '.$FieldName.'<br />Please check parameters on the module configuration...';
          $Value = 1;
        } 
        else {
          $Value = 0;
        };
    };

    Return $Value;  
};

?>