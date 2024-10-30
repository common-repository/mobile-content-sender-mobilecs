<?php																				

$domainnamea=$_SERVER['HTTP_HOST'];
$domainnamea = str_replace("www.", "", "$domainnamea");

$selfa=$_SERVER['PHP_SELF'];
$foldera = dirname($selfa);

if(isset($_POST['upload']))
	{


		$area = $_POST['area'];
		$pre = $_POST['pre'];
		$last = $_POST['last'];
		$prov = $_POST['prov'];


		if((is_numeric($area)) && (is_numeric($pre)) && (is_numeric($last)) && (is_numeric($prov)) && ((strlen($area))==3) && ((strlen($pre))==3) && ((strlen($last))==4) && ($prov<17) && ($prov>0)){

		$number="$area$pre$last";


if($prov == '1'){$ext='@message.alltel.com';}
elseif($prov == '2'){$ext='@cingularme.com';}
elseif($prov == '3'){$ext='@mms.mycricket.com';}
elseif($prov == '4'){$ext='@mymetropcs.com';}
elseif($prov == '5'){$ext='@messaging.nextel.com';}
elseif($prov == '6'){$ext='@messaging.sprintpcs.com';}
elseif($prov == '7'){$ext='@tmomail.net';}
elseif($prov == '8'){$ext='@email.uscc.net';}
elseif($prov == '9'){$ext='@vtext.com';}
elseif($prov == '10'){$ext='@vmobl.com';}
elseif($prov == '11'){$ext='@txt.bellmobility.ca';}
elseif($prov == '12'){$ext='@fido.ca';}
elseif($prov == '13'){$ext='@text.mts.net';}
elseif($prov == '14'){$ext='@pcs.rogers.com';}
elseif($prov == '15'){$ext='@sms.sasktel.com';}
elseif($prov == '16'){$ext='@msg.telus.com';}

$to="$number$ext";
$step1="1";
						}else{$suff='(Please fill fields correctly)';}


			function getFileExtension($str) {

			        $i = strrpos($str,".");
			        if (!$i) { return ""; }

			        $l = strlen($str) - $i;
			        $ext = substr($str,$i+1,$l);
	
        			return $ext;
		
						    }

		$imgfile_name=$_FILES["mobile"]["name"];
  		$imgfile_type=$_FILES["mobile"]["type"];
		$imgfile_size=$_FILES["mobile"]["size"];
		$imgfile=$_FILES["mobile"]["tmp_name"];

		//check for no existing filetype. maybe no extension in file upload
		if((!isset($imgfile_type)) || ($imgfile_type=='application/octet-stream')){$noext='1';}
		
		//check max file size
		if(($imgfile_size > 1000000) || ($imgfile_size == 0)){$error="Please upload file up to 1000Kb<br>";$donot="1";}

		$uploaddir = "./up";

		$pext = getFileExtension($imgfile_name);
    		$pext = strtolower($pext);
    			if (($pext != "jpg") && ($pext != "jpeg") && ($pext != "gif") && ($pext != "mp3") && ($pext != "aac") && ($pext != "amr") && ($pext != "qcp") && ($pext != "3gp") && ($pext != "3g2") && ($pext != "mp4") && ($noext==1))
  			  {
   			     $suff="(Filetype not allowed)";

			  }

		//get image physical pixel size
		$imgsize = GetImageSize($imgfile);
		
		//random filename to make each unique and for security reasons
		function createRandom() { 

    		$chars = "abcdefghijkmopqrstuvwxyz02346789"; 
	    	srand((double)microtime()*1000000); 
    		$i = 0; 
    		$random_string = '' ; 

    		while ($i <= 6) { 
        		$num = rand() % 33; 
        		$tmp = substr($chars, $num, 1); 
        		$random_string = $random_string . $tmp; 
        		$i++; 
    		} 

    		return $random_string; 

					} 

		$rstring = createRandom();

		    $newfile = $uploaddir . "/$rstring" . "." . "$pext";
		    if($error){$newfile='';}
    
		    /*== do extra security check to prevent malicious abuse==*/
		    if ((is_uploaded_file($imgfile)) && (!$error))
		    {
		       $do="1";
		       /*== move file to proper directory ==*/
		       if (!copy($imgfile,"$newfile")) 
		       {
		          /*== if an error occurs the file could not
		               be written, read or possibly does not exist ==*/
		          $error="Unexpected Error in Upload. Please contact us at $domainnamea";
		       }
		     }

    /*== delete the temporary uploaded file ==*/
    if(!isset($donot)){unlink($imgfile);}

    //chmod for security & find out if all went perfectly, which it always does :)
    if((isset($do)) && (!isset($error))){chmod("$newfile", 0444);$step2="1";}
	}

if(($step1==1) && ($step2==1)){

//ok, we can go to the last step

$domain="$domainnamea/";

$downloadfull="$domain$foldera";
$downloadfull = str_replace('//', "/", $downloadfull);

$vtxt='@vtext.com';
$uscc='@email.uscc.net';

function sprint()
{
$GLOBALS['sufp']=$GLOBALS['downloadfull'] . "/up/" . $GLOBALS['rstring'] . ".gcd"; //address where to point phone to
$myFile = "up/" . $GLOBALS['rstring'] . ".gcd";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Content-Type: " . $GLOBALS['imgfile_type']. "\n";
fwrite($fh, $stringData);
$stringData = "Content-Name: " . $GLOBALS['rstring'] . "\n";
fwrite($fh, $stringData);
$stringData = "Content-Version: 1.0\n";
fwrite($fh, $stringData);
$stringData = "Content-Vendor:" . $GLOBALS['number'] . "\n";
fwrite($fh, $stringData);
$stringData = 'Content-URL: http://' . $GLOBALS['downloadfull'] . "/up/" . $GLOBALS['rstring'] . "." . $GLOBALS['pext'] . "\n";
fwrite($fh, $stringData);
$stringData = "Content-Size: " . $GLOBALS['imgfile_size'] . "\n";
fwrite($fh, $stringData);
fclose($fh);
chmod("$myFile", 0444);
}

function other()
{
$GLOBALS['sufp']=$GLOBALS['downloadfull'] . "/up/" . $GLOBALS['rstring'] . "." . $GLOBALS['pext']; //address where to point phone to
}

function verizon()
{

//send file by mms email gateway
if($GLOBALS['ext'] == $GLOBALS['uscc']){$gwmms='@mms.uscc.net';}else{$gwmms='@vzwpix.com';}

$myFile = "up/" . $GLOBALS['rstring'] . "." . $GLOBALS['pext'];
$subject = 'File Upload'; 
$random_hash = md5(date('r', time())); 
$headers = "From: info@$domainnamea\r\nReply-To: $domainnamea"; 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents("$myFile"))); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Enjoy the File 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Enjoy the File 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: <?php echo $GLOBALS['imgfile_type']; ?> name="<?php echo $GLOBALS['rstring'].'.'.$GLOBALS['pext']; ?>"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $GLOBALS['to'], $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
//echo $mail_sent ? "Mail sent" : "Mail failed"; 
if($mail_sent=="Mail sent"){$GLOBALS['vz']="1";}else{$GLOBALS['vz']="2";}
}


if(($ext == $vtxt) || ($ext == $uscc)){verizon();}

else{
$sprn='@messaging.sprintpcs.com';
$sprn2='@txt.bellmobility.ca';
$sprn3='@msg.telus.com';
$sprn4='@text.mts.net';
$sprn5='@sms.sasktel.com';
if(($ext == $sprn) || ($ext == $sprn2) || ($ext == $sprn3) || ($ext == $sprn4) || ($ext == $sprn5)){sprint();}
else{other();}}

if($vz==1){$suff="(Uploaded! File was sent to you)";}elseif($vz==2){$suff="(Unexpected Error in Sending)";}else{

$subject='Get File';

$messagedw="Go to: http://$sufp to download file";

$headers = "From: info@$domainnamea\r\nReply-To: info@$domainnamea"; 

if ( mail($to,$subject,$messagedw,$headers) ) {

  $suff="(Text was sent with instructions)";

 } else {

 $suff="(Text message failed)";

 }

}
		 }
?>
<html>
<head>
<STYLE type="text/css"> 
.area{width:27px;height:21px;}
.last{width:35px;height:21px;}
.menuna{font-size:12px;font-family:arial narrow;line-height:19px;border:2px solid #3399CC;background:#EEF2FD;}
.menuna td{padding-bottom:3px;padding-left:2px;padding-right:2px;}
.bottom td{font-size:17px;padding-left:10px;padding-right:10px;text-align:center}
.sm{font-size:11px}
#carriers select{font-size:11px;width:110px;}
#carriers option{font-size:11px;width:110px;}
.tp td{vertical-align:top;font-size:13px;}
p{text-align:justify;font-size:11px}
input{color:#525252}


.SI-FILES-STYLIZED label.cabinet
{
    width: 110px;
   height: 22px;
    background: url(btn-choose-file.gif) 0 0 no-repeat;

    display: block;
    overflow: hidden;
    cursor: pointer;
}
.SI-FILES-STYLIZED label.cabinet input.file
{
    position: relative;
    height: 100%;
    width: auto;
    opacity: 0;
    -moz-opacity: 0;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}
</STYLE> 
<script type="text/javascript" src="si.files.js"></script>
</head>
<body>
<div align=center style="height:25px;font-size:11px;font-weight:bold;"><?php echo $suff;?></div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="upload"><table cellspacing=3 class=menuna cellpadding=2 align=center> 
<tr><td colspan=2 align=center><b><u>Send Content to Cell Phone</u></b></td></tr>
<tr><td colspan=2 align=center></td></tr><tr><td>Mobile&nbsp;#&nbsp;</td><td>(<input type="text" name="area" maxlength="3" class="area" onKeyUp="next()" value="">)&nbsp;<input type="text" name="pre" maxlength="3" class="area" onKeyUp="next1()" value="">-<input type="text" name="last" maxlength="4" class="last" value=""></td></tr> 
<tr><td>Carrier&nbsp;</td><td><select id=carriers name='prov'><option>Select Carrier</option><option value='1'>Alltel</option><option value='2'>AT&T</option><option value='3'>Cricket</option><option value='4'>Metro PCS</option></option><option value='5'>Nextel</option><option value='6'>Sprint PCS</option><option value='7'>T-Mobile</option><option value='8'>Us Cellular</option> 
<option value='9'>Verizon</option><option value='10'>Virgin Mobile</option><option value='11'>Bell (Canada)</option><option value='12'>Fido (Canada)</option><option value='13'>MTS (Canada)</option><option value='14'>Rogers (Canada)</option><option value='15'>Sasktel (Canada)</option><option value='16'>Telus (Canada)</option></select></td></tr> 
<tr><td>File&nbsp;</td><td><input type="hidden" name="MAX_FILE_SIZE" value="1000000"><label class="cabinet"><input name="mobile" type="file" class="file"></label></td></tr> 
<tr><td colspan=2 style="width:110px;text-align:center;">* Message & data rates may apply depending on your own phone plan.</td></tr>
<tr><td colspan=2 align=center><br><input name="upload" type="submit" value="Upload" style="width:132px;height:26px;background:#46A026;color:#ffffff;font-weight:bold;font-size:14px;"></form></td></tr></table> 
<script type="text/javascript" language="javascript">
SI.Files.stylizeAll();
</script>
</body>
</html>