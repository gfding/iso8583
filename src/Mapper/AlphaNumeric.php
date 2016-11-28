<?php
namespace ISO8583\Mapper;

class AlphaNumeric extends AbstractMapper
{
	public function pack($message)
	{
		$packed = bin2hex($message);

		if ($this->variableLength > 0) {
			$packed = sprintf('%0' . $this->variableLength . 'd', strlen($packed) / 2) . $packed;
		}

		return $packed;
	}

	public function unpack(&$message)
	{
		if ($this->variableLength > 0) {
			$length = (int)hex2bin(substr($message, 0, $this->variableLength * 2));
		} else {
			$length = $this->length;
		}

		$parsed = hex2bin(substr($message, $this->variableLength, $length * 2));
		$message = substr($message, $length * 2 + $this->variableLength);

		return $parsed;
	}
}