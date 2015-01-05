<?php

/**
 * 
 * PHP Error Checker v0.1
 * By AyoobAli.com
 * 
 */

$path = "";
$site = "";
$Error['Fatal'] = 1;
$Error['Parse'] = 1;
$Error['Warning'] = 1;
$Error['Notice'] = 1;
$custom = 0;

if ( $argv[1] ) {
	$path = $argv[1];
}
if ( $argv[2] ) {
	$site = $argv[2];
}

if ( count( $argv ) > 3 ) {
	$Error['Fatal'] = 0;
	$Error['Parse'] = 0;
	$Error['Warning'] = 0;
	$Error['Notice'] = 0;
	$custom = 1;
}

if ( substr( $site, -1 ) != "/" ) {
	$site = $site . "/";
}

$spline = str_repeat( "=", 90 ) . "\n";

echo "\n" . $spline . "                          [ Error Checker v0.1 By AyoobAli.com ]\n";
echo "Usage: errorChecker.php DirPath SiteURL [CustomSearch] [CustomSearch] [CustomSearch] [...]\n";
echo "Ex.: errorChecker.php \"/var/www/script\" \"http://localhost/script\" \"Text To Find\" \"Or This\"\n" .
	$spline;

if ( $path && $site ) {
	$dir = new RecursiveDirectoryIterator( $path );
	$itr = new RecursiveIteratorIterator( $dir );
	$ittl = iterator_count( $itr );
	$itr->rewind();
	$ttl = 0;
	$num = 0;
	$err = 0;
	$ftl = 0;
	$prs = 0;
	$wrn = 0;
	$ntc = 0;
	$cst = 0;
	$sct = "";
	$CustomText = "";

	echo "Path: " . $path . "\n";
	echo "Site: " . $site . "\n";
	if ( $custom ) {
		echo "Custom text: ";
		for ( $i = 3; $i < count( $argv ); $i++ ) {
			$CustomText .= "\"" . strtolower( $argv[$i] ) . "\", ";
		}
		echo "$CustomText\n";
	}
	echo $spline;

	while ( $itr->valid() ) {
		$ttl++;
		$filePath = $itr->getSubPathName();
		$filePath = str_replace( "\\", "/", $filePath );

		echo str_repeat( " ", strlen( $sct ) ) . "\r";
		$sct = "     Scanning      : " . $ttl . " / " . $ittl . "      [" . $filePath . "]\r";
		echo $sct;

		$errMsg = "";
		if ( !$itr->isDot() ) {


			if ( substr( $filePath, -4 ) != ".png" && substr( $filePath, -4 ) != ".jpg" && substr( $filePath, -4 ) !=
				".gif" ) {

				$GetData = @file_get_contents( $site . $filePath );
				$GetData = strtolower( $GetData );
				$ftlErr = strpos( $GetData, "fatal error</b>:" );
				$prsErr = strpos( $GetData, "parse error</b>:" );
				$wrnErr = strpos( $GetData, "warning</b>:" );
				$ntcErr = strpos( $GetData, "notice</b>:" );

				if ( $custom ) {
					$nErr = 0;

					for ( $i = 3; $i < count( $argv ); $i++ ) {

						$cstTxt = strpos( $GetData, strtolower( $argv[$i] ) );
						if ( $cstTxt ) {
							$cst++;
							$errMsg .= "\"" . strtolower( $argv[$i] ) . "\", ";

						}
					}
				}


				if ( $ftlErr && $Error['Fatal'] ) {
					$ftl++;
					$errMsg .= "Fatal, ";
				}
				if ( $prsErr && $Error['Parse'] ) {
					$prs++;
					$errMsg .= "Parse, ";
				}
				if ( $wrnErr && $Error['Warning'] ) {
					$wrn++;
					$errMsg .= "Warning, ";
				}
				if ( $ntcErr && $Error['Notice'] ) {
					$ntc++;
					$errMsg .= "Notice, ";
				}

				if ( $errMsg ) {
					$num++;
					echo str_repeat( " ", strlen( $sct ) ) . "\r";
					echo "\r" . $num . ' - ' . $site . $filePath . " [" . substr( $errMsg, 0, -2 ) . "]\n";
				}

			}

		}

		$itr->Next();
	}

	echo $spline;
	echo "Scanned Files\t: " . $ttl . " / " . $ittl . "\n";
	if ( $Error['Fatal'] ) {
		echo "Fatal error\t: " . $ftl . "\n";
	}
	if ( $Error['Parse'] ) {
		echo "Parse error\t: " . $prs . "\n";
	}
	if ( $Error['Warning'] ) {
		echo "Warning\t\t: " . $wrn . "\n";
	}
	if ( $Error['Notice'] ) {
		echo "Notice\t\t: " . $ntc . "\n";
	}
	if ( $custom ) {
		echo "Custom\t\t: " . $cst . "\n";
	}
	echo "-----------------\nTotal pages\t: " . $num . "\n";
	echo $spline;
}

?>
