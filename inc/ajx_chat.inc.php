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
    function acceptMessages() {
        $sUsername = $GLOBALS['aLMemInfo']['name'];
        $iUserID = (int)$GLOBALS['aLMemInfo']['id'];
        if($sUsername && isset($_POST['s_message']) && $_POST['s_message'] != '') {
            $sMessage = $GLOBALS['MySQL']->process_db_input($_POST['s_message'], A_TAGS_STRIP);
            if ($sMessage != '') {
                $GLOBALS['MySQL']->res("INSERT INTO `s_ajax_chat_messages` SET `member_id`='{$iUserID}', `member_name`='{$sUsername}', `message`='{$sMessage}', `when`=UNIX_TIMESTAMP()");
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
        $aMessages = $GLOBALS['MySQL']->getAll("SELECT `s_ajax_chat_messages`.*, `s_members`.`name`, UNIX_TIMESTAMP()-`s_ajax_chat_messages`.`when` AS 'diff' FROM `s_ajax_chat_messages` INNER JOIN `s_members` ON `s_members`.`id` = `s_ajax_chat_messages`.`member_id` ORDER BY `id` DESC LIMIT 15");

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
        <strong><span class="title">' . $aMessage['name'] . '</span></strong>
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

