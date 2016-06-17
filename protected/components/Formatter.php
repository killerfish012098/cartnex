<?php
class Formatter extends CFormatter
{
    private $currencies=array();
	private $currency;

    public function __construct()
    {
        foreach(Library::getCurrencies() as $currency)
        {
			$this->currencies[$currency['code']]=array(
                    'id_currecy'   => $currency['id_currency'],
                    'name'         => $currency['name'],
                    'code'   => $currency['code'],
                    'symbol'  => $currency['symbol'],
                    'position' => $currency['position'],
                    'decimal_separator'  => $currency['decimal_separator'],
                    'thousand_separator' => $currency['thousand_separator'],
                    'decimals'  => $currency['decimals'],
                    'value'  => $currency['value']
            );	
        }
    }

	public function set($currency)
	{
		$this->currency=$currency;
	}

    public function format($number, $currency = '', $value = '',$format=true) 
    {
	
		//echo "value of ".$currency;    
		if($currency  && isset($this->currencies[$currency]))
        {
			//exit('in');
			$position   = $this->currencies[$currency]['position'];
            $symbol  = $this->currencies[$currency]['symbol'];
            $decimalSeparator = $this->currencies[$currency]['decimal_separator'];
            $thousandSeparator = $this->currencies[$currency]['thousand_separator'];
            $decimals = $this->currencies[$currency]['decimals'];
        } else //default 
        {
			//exit('else');
			$currency=$this->currency;
			$position   = $this->currencies[$currency]['position'];
            $symbol  = $this->currencies[$currency]['symbol'];
            $decimalSeparator = $this->currencies[$currency]['decimal_separator'];
            $thousandSeparator = $this->currencies[$currency]['thousand_separator'];
            $decimals = $this->currencies[$currency]['decimals'];
        }

        $value=$value!=""?(float)$number *$value:(float)$number *$this->currencies[$currency]['value'];;		
        $text = '';
        $decimalSeparator=$format?$decimalSeparator:'.';
        $thousandSeparator=$format?$thousandSeparator:'';

        $text= number_format(round($value, (int)$decimals), (int)$decimals, $decimalSeparator, $thousandSeparator);

        if($format)
        {
                $text=$position=='LEFT'?$symbol.$text:$text.$symbol;
        }

        return $text;
    }
}