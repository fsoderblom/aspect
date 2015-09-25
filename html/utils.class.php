<?php


class utils
{

	var $_param1;
	var $_param2;
	var $_param3;
		

	/**
	 * Constructor
	 */
	function utils($param1=-1, $param2=-1, $param3=-1)
	{
		$this->_param1 = $param1;
		$this->_param2 = $param2;
		$this->_param3 = $param3;
	}
	

	/**
	 * setBit - sets a bit to 1 if not already set in param1 and return param1 again.
	 *
	 * @param allBits int - a numeric value.
	 * @param bit int - a number representing a bit. 1, 2, 4, 8, 16, 32, 64, etc
	 * @author Peter Nolin
	 */
	function setBit($bit)
	{
		if(is_int($bit) && is_int($this->_param1))
		{
			$tmp = pow(2,(int)$bit);
	
			if(($this->_param1 & $tmp) != $tmp) {
				$this->_param1 += (1 << $bit);
			}
		}
	
		return $this->_param1;
	}



	/**	
	 * unsetBit - set bit to zero in param1 and returns param1 again.
	 *
	 * @param allBits int - a numeric value.
	 * @param bit int - a number representing a bit. 1, 2, 4, 8, 16, 32, 64, etc
	 * @author Peter Nolin
	 */
	function unsetBit($bit)
	{
		if(is_int($bit) && is_int($this->_param1))
		{
			$tmp = pow(2,(int)$bit);
	
			if(($this->_param1 & $tmp) != $tmp) {
				$this->_param1 -= (1 << $bit);
			}
		}
	
		return $this->_param1;
	}
}
?>
