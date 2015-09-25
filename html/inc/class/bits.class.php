<?php
/**
 * class bits - a utilityclass for manupilating bits in various vays.
 *
 * @author Peter Nolin - codern@home.se
 * @since 2005-05
 */
class bits
{

	/**
	 * Constructor - currently unused
	 */
	function bits()
	{
	}
	

	/**
	 * setBit - sets a bit to 1 if not already set in param1 and return param1 again.
	 *
	 * @param src int - a number. Can be everything between 0 and 32767 or more. 
	 * @param bit int - a number representing a bit POSITION. From the right. 0,1,2,3,4 and so on.
	 * @return src int - same as param 1. But now modified.
	 * @author Peter Nolin
	 */
	function setBit($src,$bit)
	{
		if(is_numeric($bit) && is_numeric($src))
		{
			$tmp = pow(2,(int)$bit);
	
			if(($src & $tmp) != $tmp) {
				$src += (1 << $bit);
			}
		}
	
		return $src;
	}



	/**	
	 * unsetBit - set bit to zero in param1 and returns param1 again.
	 *
	 * @param src int - a number. Can be everything between 0 and 32767 or more. 
	 * @param bit int - a number representing a bit POSITION. From the right. 0,1,2,3,4 and so on.
	 * @return src int - same as param 1. But now modified.
	 * @author Peter Nolin
	 */
	function unsetBit($src, $bit)
	{
		if(is_numeric($bit) && is_numeric($src))
		{
			$tmp = pow(2,(int)$bit);
	
			if(($src & $tmp) == $tmp) {
				$src -= (1 << $bit);
			}
		}
	
		return $src;
	}


	/**
	 * checkBit - checks if a particular bit is set
	 *
	 * @param src int - a number. Can be everything between 0 and 32767 or more. 
	 * @param bit int - a number representing a bit POSITION. From the right. 0,1,2,3,4 and so on.
	 * @return boolean
	 * @author Peter Nolin
	 */
	function checkBit($src, $bit)
	{
		if(is_numeric($bit) && is_numeric($src))
		{
			return (((integer)$src & (1 << $bit)) > 0);
		}
		else return false;
	}

}
?>
