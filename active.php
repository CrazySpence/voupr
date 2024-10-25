<?php
require "headerdata.php";
require "../secrets.inc";
$page_title = "Vendetta Activity Monitor";
require "header.php";
$closespan = 0;
$fp = mysqli_connect($sqlserver,$sqluser,$sqlpass,"relaydb");
?>
	<meta http-equiv="refresh" content="30; URL=active.php">

<?php

voOnline();
echo "<br/><br/>";

$SQL = "(SELECT time,data FROM log WHERE type='RELAY' ORDER BY time DESC LIMIT 50) ORDER BY time ASC";
$result = mysqli_query($fp,$SQL);

//echo "<pre>\n";
while($row = mysqli_fetch_assoc($result)) {
   echo date('H:i',strtotime($row['time'])) . " ";
   irc2html($row['data']);
   closespan();
   echo "\n";
}
//echo "</pre>";

mysqli_close($fp);

?>
   </body>
</html>

<?php
/**
 * regular expression based tokenizer,
 * first token wins.
 */
class Tokenizer
{
    private $subject;
    private $offset = 0;
    private $tokens = array(
        'color-fgbg'  => '\x03(\d{1,2}),(\d{1,2})',
        'color-fg'    => '\x03(\d{1,2})',
        'color-reset' => '\x03',
        'style-bold'  => '\x02',
        'catch-all' => '.|\n',
    );
    public function __construct($subject)
    {
        $this->subject = (string) $subject;
    }
    public function setOffset($offset)
    {
        $this->offset = max(0, $offset);
    }
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return array|null
     */
    public function getNext()
    {
        if ($this->offset >= strlen($this->subject))
            return NULL;

        foreach($this->tokens as $name => $token)
        {
            if (FALSE === $r = preg_match("~$token~", $this->subject, $matches, PREG_OFFSET_CAPTURE, $this->offset))
                throw new RuntimeException('Pattern for token %s failed (regex error).', $name);
            if ($r === 0)
                continue;
            if (!isset($matches[0])) {
                var_dump(substr($this->subject, $this->offset));
                $c = 1;
            }
            if ($matches[0][1] !== $this->offset)
                continue;
            $data = array();
            foreach($matches as $match)
            {
                list($data[]) = $match;
            }

            $this->offset += strlen($data[0]);
            return array($name, $data);
        }
        return NULL;
    }
}
function closespan() {
   global $closespan;

   for ($closespan ; $closespan > 0 ; $closespan--) {
      echo "</span>";
   }
}
function irc2html($data) {
/**
 * Tokenizer Example of Mirc Color and Style (bold) Codes.
 *
 * @link http://stackoverflow.com/q/10329443/367456
 * Modified by CrazySpence 2012
 */
    global $closespan;
    $tokenizer = new Tokenizer($data);

    $colours = array(
        "01" => "black",
        "02" => "navy",
        "03" => "green",
        "04" => "red",
        "05" => "brown",
        "06" => "purple",
        "07" => "olive",
        "08" => "yellow",
        "09" => "lime",
        "10" => "teal",
        "11" => "aqua",
        "12" => "royalblue",
        "13" => "hotpink",
        "14" => "darkgray",
        "15" => "lightgray",
        "16" => "white",
    );

    while(list($token, $data) = $tokenizer->getNext())
    {
        switch($token)
        {
            case 'color-fgbg':
                printf('<span style="color:%s;background-color:%s">', $colours[$data[1]], $colours[$data[2]]);
                $closespan++;
                break;

            case 'color-fg':
                printf('<span style="color:%s">', $colours[$data[1]]);
                $closespan++;
                break;

            case 'color-reset':
                printf('</span>');
                $closespan--;
                break;
            case 'style-bold';
                printf('<span style="font-weight:bold">');
                break;

            case 'catch-all':
                echo htmlspecialchars($data[0]);
                break;

            default:
                throw new Exception(sprintf('Unknown token <%s>.', $token));
	}
    }
    echo "<br/>";
}

function voOnline() {
    global $sqlserver;
    global $vosqluser;
    global $vosqlpass;    
    $db = mysqli_connect($sqlserver,$vosqluser,$vosqlpass,"vendetta_online");	
    $sql = "SELECT user from user_tracker WHERE (DATE_SUB(NOW(), INTERVAL 1440 MINUTE)) <= seen";
    $result = mysqli_query($db,$sql);
    $count = mysqli_num_rows($result);
    $buf = sprintf("In game recently(%d):",$count);
    while ($row = mysqli_fetch_row($result)) {
        $buf = strcat($buf," \"");
        $buf = strcat($buf,$row[0]);
        $buf = strcat($buf,"\",");
	/*if(strlen($buf) >= 255) {
            $buf = strcat($buf,"\n");
            echo $buf;
            $buf = sprintf("PRIVMSG %s :",$to);
	}*/
    }
    $buf = strcat($buf,"\n");
    echo "<span style='color:white'>\n";
    echo $buf;
    echo "</span>\n";
    mysqli_close($db);
}
function strcat($orig,$add) {
    return sprintf("%s%s",$orig,$add);
}
require "footer.php";
?>
