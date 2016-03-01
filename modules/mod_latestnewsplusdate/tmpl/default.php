<?php 
/**
 * @version		$Id: mod_latestnewsplusdate.php 2.1.0
 * @Rony S Y Zebua (Joomla 1.7 & Joomla 2.5 & Joomla 3.0)
 * @Official site http://www.templateplazza.com
 * @based on mod_latestnews
 * @package		Joomla 3.0.x 
 * @subpackage	mod_latestnewsplusdate
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
 // no direct access
defined('_JEXEC') or die('Restricted access'); 


// call again as this var have been changed
$numofintrotext	= $params->get( 'numofintrotext', 1 );
//init values
$counting = 0; $n=0;
if ($show_introtext>0) {
foreach($list as $index=>$item) 
{
	$images = json_decode($item->images);
	$introImage = htmlspecialchars( $images->image_intro );
	$fulltextImage = htmlspecialchars( $images->image_fulltext );
?>
   
	<div class="div_lnd_intro">
		<div class="lnd_head">
       
    <?php
	if ($loadorder == 1) 
	{
		if ( !empty($introImage) ) { ?>
			<img src="<?php echo lnpResizeImageHelper::getResizedImage('/'.$item->image, $thumb_width, $thumb_height, 'crop'); ?>" alt="<?php echo $item->imgalt; ?>" title="<?php echo $item->imgtitle; ?>" style="height:<?php echo $thumb_height; ?>px;width:<?php echo $thumb_width ?>px" />
		
		<?php } elseif ( empty($introImage) && !empty($fulltextImage) ) { ?>
			<img src="<?php echo lnpResizeImageHelper::getResizedImage('/'.$item->image, $thumb_width, $thumb_height, 'crop'); ?>" alt="<?php echo $item->imgalt; ?>" title="<?php echo $item->imgtitle; ?>" style="height:<?php echo $thumb_height; ?>px;width:<?php echo $thumb_width ?>px" />
			
		<?php } else /*if( empty($introImage) && empty($fulltextImage) && !empty($item->image) )*/ { 
			echo modLatestNewsHelperPlusDate::lnd_showThumb($item->image,$params,$item->id,$item->slug,$item->catslug,$item->link);
		} 
	}
	?>
            <a class='lndtitle' href="<?php echo $item->link; ?>"><?php echo $item->text; ?></a>
            <br/>
    <?php
	if($show_date==1) 
	{
			switch($show_date_type) {
				case 1:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC2'), $offset); // l, d F Y H:i
					echo "<br/></span>";
					break;
				case 2:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC3'), $offset); // d F Y
					echo "<br/></span>";
					break;
				case 3:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),'H:i', $offset); // hour:minute
					echo "<br/></span>";
					break;
				case 4:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),'D, M jS Y', $offset); // Day name(short), Month(short) date th Year
					echo "<br/></span>";
					break;
				case 5:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),'l, F jS Y H:i', $offset); // Day name(short), Month(short) date th Year Hour:minute
					echo "<br/></span>";
					break;
				default:
					echo "<span class=\"lnd_introdate\">";
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC1'), $offset); // l, d F Y
					echo "<br/></span>";
					break;
			}
	}
	
	?>
	       <div class='clrfix'></div>
        </div>
        
        <div class='lnd_introtxt'>
       
        <?php
        if ($loadorder == 0) {
			
			if ( !empty($introImage) ) { ?>
				<img src="<?php echo lnpResizeImageHelper::getResizedImage('/'.$item->image, $thumb_width, $thumb_height, 'crop'); ?>" alt="<?php echo $item->imgalt; ?>" title="<?php echo $item->imgtitle; ?>" style="height:<?php echo $thumb_height; ?>px;width:<?php echo $thumb_width; ?>px" />
		
			<?php } elseif ( empty($introImage) && !empty($fulltextImage) ) { ?>
				<img src="<?php echo lnpResizeImageHelper::getResizedImage('/'.$item->image, $thumb_width, $thumb_height, 'crop'); ?>" alt="<?php echo $item->imgalt; ?>" title="<?php echo $item->imgtitle; ?>" style="height:<?php echo $thumb_height; ?>px;width:<?php echo $thumb_width; ?>px" />
			
			<?php } elseif ( empty($introImage) && empty($fulltextImage) ) { 
				
				modLatestNewsHelperPlusDate::lnd_showThumb($item->image,$params,$item->id,$item->slug,$item->catslug,$item->link);				
			} 
		}
            
		//echo html_entity_decode(htmlentities($item->introtext));
		//echo $item->introtext;
		echo $item->displayIntrotext;
        ?>
        
            <div class='clrfix'></div>
    
        </div>
        
	</div>
<?php 
	$counting++;
	if($counting == $numofintrotext) break;
} 
?>
	<div class='clrfix'></div>
<?php } /* end if show_introtext*/ ?>

<div class="div_lnd_list">
<!-- LatestNews Plus Date Module - Another Quality Freebie from TemplatePlazza.com -->
    <ul class="lnd_latestnews">
    <?php 
	for($n = $counting; $n < count($list); $n++)
	{
		$item = $list[$n];
	?>
		<li class="lnd_latestnews">
		<?php
		
		if ( $show_date==1 )
		{
			switch($show_date_type) 
			{
				case 1:
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC2'), $offset); // l, d F Y H:i
					break;
				case 2:
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC3'), $offset); // d F Y
					break;
				case 3:
					echo JHTML::_('date', htmlspecialchars( $item->created ),'H:i', $offset); // hour:minute
					break;
				case 4:
					echo JHTML::_('date', htmlspecialchars( $item->created ),'D, M jS Y', $offset); // Day name(short), Month(short) date th Year
					break;
				case 5:
					echo JHTML::_('date', htmlspecialchars( $item->created ),'l, F jS Y H:i', $offset); // Day name(short), Month(short) date th Year Hour:minute
					break;
				default:
					echo JHTML::_('date', htmlspecialchars( $item->created ),JText::_('DATE_FORMAT_LC1'), $offset); // l, d F Y
					break;
			}
		}
	?>
			<a href="<?php echo $item->link; ?>" class="latestnews">
				<?php echo $item->text; ?>
			</a>
        </li>
<?php 
	} // END FOR
?>
    </ul>
</div>
<div class='clrfix'></div>

<?php //Added by Ronysyz to change the old system of SHOW_MORE_IN	
if($show_more_in) {

	echo '<div class="lnd_more_ind">';
	   echo "<span><strong>". JText::_( 'MOD_LATESTNEWSPLUSDATE_MORE_IN' ) ."</strong></span>";
	 
	$cidbegin = 0;
	
	for ($n=0; $n<count($list); $n++) 
    {
		$item = $list[$n];
		$cidnow = $item->catid;
		$cidcheckin = $cidnow - $cidbegin;
		
        if($cidcheckin != 0)
        {
			if ($show_more_type) { 
                echo '<a href="'.$item->categblog.'">'.$item->categtitle.'</a>';
            } else {
                echo '<a href="'.$item->categlist.'">'.$item->categtitle.'</a>';
            }
			echo '&nbsp;&nbsp;';
        }
		
        $cidbegin = $cidnow;
	}

	echo '</div>';
}
?>