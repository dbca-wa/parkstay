<?php

defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

/**
#
 * Lists the properties, according to property uids passed from a search function
#
 *
 * @package Jomres
#
 */
class j06000maplist
        {
        /**
        #
         * Constructor: Executes the sql query to find property details of those property uids passed by a search, then displays those details in the list_propertys patTemplate file
        #
         */
        function j06000maplist()
                {
//echo "Hello"; die();
                $MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
                if ( $MiniComponents->template_touch )
                        {
                        $this->template_touchable = false;

                        return;
                        }
                $MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
                $MiniComponents->triggerEvent( '00030' ); //Search mini-comp
                }

        /**
        #
         * Must be included in every mini-component
        #
         * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
        #
         */
        // This must be included in every Event/Mini-component
        function getRetVals()
                {
                return null;
                }
        }
?>
