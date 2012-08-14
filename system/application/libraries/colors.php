<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colors
{
	var $PREVIEW_WIDTH    = 150;
	var $PREVIEW_HEIGHT   = 150;

	var $error;

	function Get_Color($img, $count = 10, $reduce_brightness = true, $reduce_gradients = true, $delta =16)
	{
		
		if (is_readable( $img ))
		{
			if ( $delta > 2 )
			{
				$half_delta = $delta / 2 - 1;
			}
			else
			{
				$half_delta = 0;
			}
			// WE HAVE TO RESIZE THE IMAGE, BECAUSE WE ONLY NEED THE MOST SIGNIFICANT COLORS.
			$size = GetImageSize($img);
			$scale = 1;
			if ($size[0]>0)
			$scale = min($this->PREVIEW_WIDTH/$size[0], $this->PREVIEW_HEIGHT/$size[1]);
			if ($scale < 1)
			{
				$width = floor($scale*$size[0]);
				$height = floor($scale*$size[1]);
			}
			else
			{
				$width = $size[0];
				$height = $size[1];
			}
			$image_resized = imagecreatetruecolor($width, $height);
			if ($size[2] == 1)
			$image_orig = imagecreatefromgif($img);
			if ($size[2] == 2)
			$image_orig = imagecreatefromjpeg($img);
			if ($size[2] == 3)
			$image_orig = imagecreatefrompng($img);
			// WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
			imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			$im = $image_resized;
			$imgWidth = imagesx($im);
			$imgHeight = imagesy($im);
			$total_pixel_count = 0;
			for ($y=0; $y < $imgHeight; $y++)
			{
				for ($x=0; $x < $imgWidth; $x++)
				{
					$total_pixel_count++;
					$index = imagecolorat($im,$x,$y);
					$colors = imagecolorsforindex($im,$index);
					// ROUND THE COLORS, TO REDUCE THE NUMBER OF DUPLICATE COLORS
					if ( $delta > 1 )
					{
						$colors['red'] = intval((($colors['red'])+$half_delta)/$delta)*$delta;
						$colors['green'] = intval((($colors['green'])+$half_delta)/$delta)*$delta;
						$colors['blue'] = intval((($colors['blue'])+$half_delta)/$delta)*$delta;
						if ($colors['red'] >= 256)
						{
							$colors['red'] = 255;
						}
						if ($colors['green'] >= 256)
						{
							$colors['green'] = 255;
						}
						if ($colors['blue'] >= 256)
						{
							$colors['blue'] = 255;
						}
						
						$colors['red'] = $this->_graduation($colors['red']);

						$colors['green'] = $this->_graduation($colors['green']);

						$colors['blue'] = $this->_graduation($colors['blue']);
					}

					$hex = substr("0".dechex($colors['red']),-2).substr("0".dechex($colors['green']),-2).substr("0".dechex($colors['blue']),-2);

					if ( ! isset( $hexarray[$hex] ) )
					{
						$hexarray[$hex] = 1;
					}
					else
					{
						$hexarray[$hex]++;
					}
				}
			}

			// Reduce gradient colors
			if ( $reduce_gradients )
			{
				// if you want to *eliminate* gradient variations use:
				// ksort( &$hexarray );
				arsort( &$hexarray, SORT_NUMERIC );

				$gradients = array();
				foreach ($hexarray as $hex => $num)
				{
					if ( ! isset($gradients[$hex]) )
					{
						$new_hex = $this->_find_adjacent( $hex, $gradients, $delta );
						$gradients[$hex] = $new_hex;
					}
					else
					{
						$new_hex = $gradients[$hex];
					}

					if ($hex != $new_hex)
					{
						$hexarray[$hex] = 0;
						$hexarray[$new_hex] += $num;
					}
				}
			}

			// Reduce brightness variations
			if ( $reduce_brightness )
			{
				// if you want to *eliminate* brightness variations use:
				// ksort( &$hexarray );
				arsort( &$hexarray, SORT_NUMERIC );

				$brightness = array();
				foreach ($hexarray as $hex => $num)
				{
					if ( ! isset($brightness[$hex]) )
					{
						$new_hex = $this->_normalize( $hex, $brightness, $delta );
						$brightness[$hex] = $new_hex;
					}
					else
					{
						$new_hex = $brightness[$hex];
					}

					if ($hex != $new_hex)
					{
						$hexarray[$hex] = 0;
						$hexarray[$new_hex] += $num;
					}
				}
			}

			arsort( &$hexarray, SORT_NUMERIC );

			// convert counts to percentages
			foreach ($hexarray as $key => $value)
			{
				$hexarray[$key] = (float)$value / $total_pixel_count;
				
				$hexarray[$key] = $hexarray[$key] * 100;
			}

			if ( $count > 0 )
			{
				// only works in PHP5
				// return array_slice( $hexarray, 0, $count, true );

				$arr = array();
				foreach ($hexarray as $key => $value)
				{
					if ($count == 0)
					{
						break;
					}
					$count--;
					$arr[$key] = $value;
				}
				return $arr;
			}
			else
			{
				return $hexarray;
			}

		}
		else
		{
			$this->error = "Image ".$img." does not exist or is unreadable";
			return false;
		}
	}

	function _normalize( $hex, $hexarray, $delta )
	{
		$lowest = 255;
		$highest = 0;
		$colors['red'] = hexdec( substr( $hex, 0, 2 ) );
		$colors['green']  = hexdec( substr( $hex, 2, 2 ) );
		$colors['blue'] = hexdec( substr( $hex, 4, 2 ) );

		if ($colors['red'] < $lowest)
		{
			$lowest = $colors['red'];
		}
		if ($colors['green'] < $lowest )
		{
			$lowest = $colors['green'];
		}
		if ($colors['blue'] < $lowest )
		{
			$lowest = $colors['blue'];
		}

		if ($colors['red'] > $highest)
		{
			$highest = $colors['red'];
		}
		if ($colors['green'] > $highest )
		{
			$highest = $colors['green'];
		}
		if ($colors['blue'] > $highest )
		{
			$highest = $colors['blue'];
		}

		// Do not normalize white, black, or shades of grey unless low delta
		if ( $lowest == $highest )
		{
			if ($delta <= 32)
			{
				if ( $lowest == 0 || $highest >= (255 - $delta) )
				{
					return $hex;
				}
			}
			else
			{
				return $hex;
			}
		}

		for (; $highest < 256; $lowest += $delta, $highest += $delta)
		{
			$new_hex = substr("0".dechex($colors['red'] - $lowest),-2).substr("0".dechex($colors['green'] - $lowest),-2).substr("0".dechex($colors['blue'] - $lowest),-2);

			if ( isset( $hexarray[$new_hex] ) )
			{
				// same color, different brightness - use it instead
				return $new_hex;
			}
		}

		return $hex;
	}

	function _find_adjacent( $hex, $gradients, $delta )
	{
		$red = hexdec( substr( $hex, 0, 2 ) );
		$green  = hexdec( substr( $hex, 2, 2 ) );
		$blue = hexdec( substr( $hex, 4, 2 ) );

		if ($red > $delta)
		{
			$new_hex = substr("0".dechex($red - $delta),-2).substr("0".dechex($green),-2).substr("0".dechex($blue),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}
		if ($green > $delta)
		{
			$new_hex = substr("0".dechex($red),-2).substr("0".dechex($green - $delta),-2).substr("0".dechex($blue),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}
		if ($blue > $delta)
		{
			$new_hex = substr("0".dechex($red),-2).substr("0".dechex($green),-2).substr("0".dechex($blue - $delta),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}

		if ($red < (255 - $delta))
		{
			$new_hex = substr("0".dechex($red + $delta),-2).substr("0".dechex($green),-2).substr("0".dechex($blue),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}
		if ($green < (255 - $delta))
		{
			$new_hex = substr("0".dechex($red),-2).substr("0".dechex($green + $delta),-2).substr("0".dechex($blue),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}
		if ($blue < (255 - $delta))
		{
			$new_hex = substr("0".dechex($red),-2).substr("0".dechex($green),-2).substr("0".dechex($blue + $delta),-2);
			if ( isset($gradients[$new_hex]) )
			{
				return $gradients[$new_hex];
			}
		}

		return $hex;
	}

	//определить к какому числу в массиве ближе всего данное число, в данном случае числа градации, для получения безопасных цветов
	function _graduation($n)
	{
		$x = array(0, 51, 102, 153, 204, 255);

		$y = $n;

		$x[] = $y;

		sort($x);

		for($i=0, $return=$x[0]; $i<count($x)-1; $i++)
		{
			if( $x[$i+1] == $y )
			{
				if( $i+1 >= count($x) || $y-$x[$i] < $x[$i+2]-$y ) $return = $x[$i];
				else $return = $x[$i+2];
				break;
			}
		}

		return $return; 
	}

	//Линейный вариант
	function _graduation_2($n)
	{
		$x = array(0, 51, 102, 153, 204, 255);

		$y = $n;

		if( in_array($y, $x) ) 
		{
			$return=$y;
		}
		else
		{
			$x[] = $y;
			$x = array_unique($x);
			sort($x);
			$x = array_combine($x, $x);
			$keys = array_values($x);
			$key = array_search($y, $keys);
			if( $key+1 == count($x) ) $return = $x[$keys[$key-1]];
			elseif( $key == 0 ) $return = $x[$keys[$key+1]];
			elseif( $y-$x[$keys[$key-1]] < $x[$keys[$key+1]]-$y ) $return = $x[$keys[$key-1]];
			else $return = $x[$keys[$key+1]];
		}
		return $return;  
	}
	
	function rangecolors($rgb)
	{
		$colors = array(
'FFFFCC','FFFF99','FFFF66','FFFF33','FFFF00','CCCC00',
'FFCC66','FFCC00','FFCC33','CC9900','CC9933','996600',
'FF9900','FF9933','CC9966','CC6600','996633','663300',
'FFCC99','FF9966','FF6600','CC6633','993300','660000',
'FF6633','CC3300','FF3300','FF0000','CC0000','990000',
'FFCCCC','FF9999','FF6666','FF3333','FF0033','CC0033',
'CC9999','CC6666','CC3333','993333','990033','330000',
'FF6699','FF3366','FF0066','CC3366','996666','663333',
'FF99CC','FF3399','FF0099','CC0066','993366','660033',
'FF66CC','FF00CC','FF33CC','CC6699','CC0099','990066',
'FFCCFF','FF99FF','FF66FF','FF33FF','FF00FF','CC3399',
'CC99CC','CC66CC','CC00CC','CC33CC','990099','993399',
'CC66FF','CC33FF','CC00FF','9900CC','996699','660066',
'CC99FF','9933CC','9933FF','9900FF','660099','663366',
'9966CC','9966FF','6600CC','6633CC','663399','330033',
'CCCCFF','9999FF','6633FF','6600FF','330099','330066',
'9999CC','6666FF','6666CC','666699','333399','333366',
'3333FF','3300FF','3300CC','3333CC','000099','000066',
'6699FF','3366FF','0000FF','0000CC','0033CC','000033',
'0066FF','0066CC','3366CC','0033FF','003399','003366',
'99CCFF','3399FF','0099FF','6699CC','336699','006699',
'66CCFF','33CCFF','00CCFF','3399CC','0099CC','003333',
'99CCCC','66CCCC','339999','669999','006666','336666',
'CCFFFF','99FFFF','66FFFF','33FFFF','00FFFF','00CCCC',
'99FFCC','66FFCC','33FFCC','00FFCC','33CCCC','009999',
'66CC99','33CC99','00CC99','339966','009966','006633',
'66FF99','33FF99','00FF99','33CC66','00CC66','009933',
'99FF99','66FF66','33FF66','00FF66','339933','006600',
'CCFFCC','99CC99','66CC66','669966','336633','003300',
'33FF33','00FF33','00FF00','00CC00','33CC33','00CC33',
'66FF00','66FF33','33FF00','33CC00','339900','009900',
'CCFF99','99FF66','66CC00','66CC33','669933','336600',
'99FF00','99FF33','99CC66','99CC00','99CC33','669900',
'CCFF66','CCFF00','CCFF33','CCCC99','666633','333300',
'CCCC66','CCCC33','999966','999933','999900','666600',
'FFFFFF','CCCCCC','999999','666666','333333','000000'
);

		$index = '';//Необходимо узнать индекс цвета

		// этот цикл пройдется по всему массиву
		// и выведет имя ключа элемента массива
		// значение которого равно $rgb
		while ($fruit_name = current($colors))
		{
	    	if( $fruit_name == $rgb ) {
	        	$index = key($colors);
	    	}
			next($colors);
		}
		
		$start = $index - 3;

		$newcolors = array_slice($colors, $start, 7);
		
		return $newcolors;
	}
/*
array_slice( )

Функция array_slice( ) возвращает часть массива, начальная и конечная позиция которой определяется смещением от начала и необязательным параметром длины. Синтаксис функции array_slice( ): 

aqua, black, blue, fuchsia, gray, grey, green, lime, maroon, navy, olive, purple, red, silver, teal, white, and yellow
аква, черный, синий, фуксия, синий, серый, зеленый, лайм, темно-бордовый, темно-синий, оливковый, фиолетовый, красный, серебристый, бирюзовый, белый и желтый
*/
}