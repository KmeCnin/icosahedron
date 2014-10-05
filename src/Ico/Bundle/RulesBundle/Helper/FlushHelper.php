<?php

namespace Ico\Bundle\RulesBundle\Helper;

class FlushHelper {

    static $BUFFER_SIZE_APACHE = 65536;

    protected $bufferSize;
    protected $output;

    function __construct($bufferSize = null) {
        $this->bufferSize = $bufferSize ? $bufferSize : max(static::$BUFFER_SIZE_APACHE, 0);
    }

    public function out($output) {

        if(!is_scalar($output)) {
            throw new InvalidArgumentException();
	   }

        echo $output;
        echo str_repeat(' ', min($this->bufferSize,  $this->bufferSize - strlen($output)));
        ob_flush();
        flush();
    }
    
    public function consoleClose($url) {
	   return $this->out('<script type="text/javascript">window.setTimeout(function(){window.location.href = "'.$url.'";}, 1500);</script>');
    }

    public function consoleUpdate($output) {
        $output = '<span class="line">'.$output.'</span><br />';
        return $this->outPlaceholder($output, 'output');
    }
    
    public function consoleClear() {
        return $this->outPlaceholder('', 'output');
    }

    public function outPlaceholder($output, $id) {
        $out = '<script type="text/javascript">';
		  $out .= 'var output = document.getElementById("'.$id.'");';
		  $out .= 'var cursor = document.getElementById("cursor");';
		  $out .= 'if (cursor !== null && cursor.parentNode) { cursor.parentNode.removeChild(cursor); }';
		  $out .= 'output.innerHTML = output.innerHTML + "'.addslashes($output.'<span id="cursor"></span>').'";';
		  $out .= 'document.getElementById("bottom").scrollIntoView();';
        $out .= '</script>';
        return $this->out($out);
    }
}