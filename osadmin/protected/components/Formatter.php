<?php
class Formatter extends CFormatter
{
    private $currencies=array();

    public function __construct()
    {
        foreach(Currency::model()->findAll(array('condition'=>'status=1')) as $currency)
        {
            $this->currencies[$currency->code]=array(
                    'id_currecy'   => $currency->id_currency,
                    'name'         => $currency->name,
                    'code'   => $currency->code,
                    'symbol'  => $currency->symbol,
                    'position' => $currency->position,
                    'decimal_separator'  => $currency->decimal_separator,
                    'thousand_separator' => $currency->thousand_separator,
                    'decimals'  => $currency->decimals,
                    'value'  => $currency->value
            );	
        }
    }

    public function format($number, $currency = '', $value = '',$format=true) 
    {

        
		if($currency  && isset($this->currencies[$currency]))
        {
            $position   = $this->currencies[$currency]['position'];
            $symbol  = $this->currencies[$currency]['symbol'];
            $decimalSeparator = $this->currencies[$currency]['decimal_separator'];
            $thousandSeparator = $this->currencies[$currency]['thousand_separator'];
            $decimals = $this->currencies[$currency]['decimals'];
        } else //default 
        {
			$position   = 'RIGHT';
            $symbol   = $currency;
            $decimalSeparator = '.';
            $thousandSeparator = ',';
            $decimals = '2';
            /*
			if currency in order not available in application will display order currency with some default settings instead of showing in default currency.currency should be passed compuslory
			$position   = $this->currencies[$this->code]['position'];
            $symbol   = $this->currencies[$this->code]['symbol'];
            $decimalSeparator = $this->currencies[$this->code]['decimal_separator'];
            $thousandSeparator = $this->currencies[$this->code]['thousand_separator'];
            $decimals = $this->currencies[$this->code]['decimals'];*/
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