<?php

	class Metrika 
	{	
		protected $token;
		protected $version;

		private $dimensions = array();
		private $metrics = array();
		private $filters = array();
		private $preset = FALSE;
		


		function __construct($token = FALSE, $version = 'v1')
		{
			$this->token = $token;
			$this->version = $version;
		}

		function __set( $name , $value )
		{        
        	if( method_exists( $this , $method = ( 'set' . ucfirst( $name  ) ) ) )
        	{
        		return $this->$method( $value );
        	}else{
        		throw new Exception( 'Can\'t set property ' . $name );
        	} 	            
    	}

    	function __get( $name )
    	{
        	return $this->$name;
    	}


		public function stat($yaMetrikaCounter, $date1 = FALSE, $date2 = FALSE, $limit = FALSE)
		{
			if (!$yaMetrikaCounter || !$this->token)
			{
				throw new Exception( 'metrika counter and token are required' );
			}

			$url = 'https://api-metrika.yandex.ru/stat/'.$this->version.'/data?oauth_token='.$this->token.'&id='.$yaMetrikaCounter;

			if( $this->preset )
			{
				$url .= '&preset=';
				$url .= $this->preset;
			}

			if ( count( $this->filters )>0 )
			{
				$url .= '&filters=';
				$url .= implode(',', $this->filters );
			}

			if ( count( $this->dimensions )>0 )
			{
				$url .= '&dimensions=';
				$url .= implode(',', $this->dimensions );
			}
		
			if ( count($this->metrics)>0 ) {
				$url .= '&metrics=';
				$url .= implode(',',$this->metrics);
			}

			if ( $date1 && $date2 )
			{
				$date1 = str_replace("-", "", $date1 );
				$date2 =  str_replace("-", "", $date2 );
				$url .= '&date1='.$date1.'&date2='.$date2;
			}

			if ($limit)
			{
				$url .= '&limit='.$limit;
			}

			return self::request($url);
		}



		public function clear()
		{
			$this->dimensions = array();
			$this->metrics = array();
			$this->filters = array();
			$this->preset = FALSE;
		}



		protected static function  request($url)
		{	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch);

			return json_decode($output,true);
		}


		public function setDimensions($value) {

			if ( !is_array($value) || count($value)>20 ) {
				throw new Exception( 'dimensions error' );
			}
        	$this->dimensions = $value;
    	}

    	public function setMetrics($value) {
    		if ( !is_array($value) || count($value)>20 ) {
				throw new Exception( 'metrics error' );
			}
        	$this->metrics = $value;
    	}

    	public function setFilters($value) {
    		if ( !is_array($value) || count($value)>20 ) {
				throw new Exception( 'filters error' );
			}
        	$this->filters = $value;
    	}

    	public function setPreset($value){
    		if ( gettype($value)!='string') {
    			throw new Exception( 'preset error' );
    		}
    		$this->preset = $value;
    	}


	}

 ?>