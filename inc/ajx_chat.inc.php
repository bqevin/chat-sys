<?php

/**
* Simple ajaxy chat class
*/
class SimpleAjaxyChat {

    /**
    * constructor
    */
    function SimpleAjaxyChat() {}

    /**
    * Adding to DB table posted message
    */

    //Added a $toUserID = 1 & $orderID = 100; variables here--HardCorded
    function acceptMessages() {
        $sUsername = $GLOBALS['aLMemInfo']['name'];
        $iUserID = (int)$GLOBALS['aLMemInfo']['id'];
        $toUserID = 1;
        $orderID = 1000;
        if($sUsername && $toUserID && isset($_POST['s_message']) && $_POST['s_message'] != '') {
            $sMessage = $GLOBALS['MySQL']->process_db_input($_POST['s_message'], A_TAGS_STRIP);
            if ($sMessage != '') {
                $GLOBALS['MySQL']->res("INSERT INTO `s_ajax_chat_messages` SET `member_id`='{$iUserID}', `member_name`='{$sUsername}', `message`='{$sMessage}', `order_id`='{$orderID}', `to_id`='{$toUserID}', `when`=UNIX_TIMESTAMP()");
            }
        }
    }

    /**
    * Return input text form
    */
    function getInputForm() {
        ob_start();
        require_once('templates/chat_input.html');
        return ob_get_clean();
    }

    /**
    * Return last 15 messages 
    */
    function getMessages($bOnlyMessages = false) {
        //Have done manual pluggin, now i need to use dynamic data
        $aMessages = $GLOBALS['MySQL']->getAll("SELECT * from s_ajax_chat_messages where order_id = 1000 and member_id=1111 or 1 ORDER BY `id` DESC LIMIT 15");
        $sMessages = '';
        // collecting list of messages
        foreach ($aMessages as $iID => $aMessage) {
            $sExStyles = $sExJS = '';
            $iDiff = (int)$aMessage['diff'];
            if ($iDiff < 7) {
                $sExStyles = 'style="display:none;"';
                $sExJS = "<script> $('#message_{$aMessage['id']}').slideToggle('slow'); </script>";
            }

            $sWhen = date("H:i:s", $aMessage['when']);
            $sMessages .= '      <li class="collection-item avatar" id="message_'.$aMessage['id'].'" '.$sExStyles.'>
      <img class="material-icons circle green" src="img/4.jpg">
        <strong><span class="title">' . $aMessage['member_name'] . '</span></strong>
       <p>' . $aMessage['message'] . '</p>
       <small> (Sent: ' . $sWhen  . ') <a href="#!" class="secondary-content"><i class="material-icons">check</i>
        </a> </small>
        
      </li>  '. $sExJS;
        }

        if ($bOnlyMessages) return $sMessages;
        return '<ul class="collection chat_main">' . $sMessages . '</ul>';
    }

}

$GLOBALS['AjaxChat'] = new SimpleAjaxyChat();

?>

