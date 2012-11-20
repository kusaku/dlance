<?php 
/**
 *
 */

class Colors {
	const width = 64;
	const height = 64;
	
	var $image;

	function loadImage($filename) {
		$type = mime_content_type($filename);
		
		switch ($type) {
			case 'image/gif':
				$image = imagecreatefromgif($filename);
				break;
			case 'image/jpeg':
				$image = imagecreatefromjpeg($filename);
				break;
			case 'image/png':
				$image = imagecreatefrompng($filename);
				break;
			default:
				return FALSE;
		}
		$this->image = imagecreatetruecolor(self::width, self::height);
		return imagecopyresampled($this->image, $image, 0, 0, 0, 0, self::width, self::height, imagesx($image), imagesy($image));
	}

	function hex2rgb($hex) {
		if (preg_match('/^(?:#|)([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})$/i', $hex, $rgb)) {
			return array(
				hexdec($rgb[1]),hexdec($rgb[2]),hexdec($rgb[3])
			);
		}
		return array(
			0,0,0
		);
	}

	function format4rgb($r, $g = NULL, $b = NULL) {
		is_array($r) and list($r,$g,$b) = array(
			$r[0],$r[1],$r[2]
		);
		return sprintf('r%xg%xb%x', $r, $g, $b);
	}

	function format4hsv($h, $s = NULL, $v = NULL) {
		is_array($h) and list($h,$s,$v) = array(
			$h[0],$h[1],$h[2]
		);
		return sprintf('h%xs%xv%x', $h, $s, $v);
	}

	function deformat($color, &$is_rgb, &$is_hsv) {
		if (preg_match('/^r([a-f0-9])g([a-f0-9])b([a-f0-9])$/i', $color, $colors)) {
			$is_hsv = !$is_rgb = TRUE;
			list($c1,$c2,$c3) = array(
				hexdec($colors[1]),hexdec($colors[2]),hexdec($colors[3])
			);
		} elseif (preg_match('/^h([a-f0-9])s([a-f0-9])v([a-f0-9])$/i', $color, $colors)) {
			$is_rgb = !$is_hsv = TRUE;
			list($c1,$c2,$c3) = array(
				hexdec($colors[1]),hexdec($colors[2]),hexdec($colors[3])
			);
		} else {
			$is_hsv = $is_rgb = FALSE;
			$c1 = $c2 = $c3 = 0;
		}
		return array(
			$c1,$c2,$c3
		);
	}

	function rgb2hsv($r, $g = NULL, $b = NULL) {
		is_array($r) and list($r,$g,$b) = array(
			$r[0],$r[1],$r[2]
		);
		
		$min = min($r, $g, $b);
		$max = max($r, $g, $b);
		
		switch (TRUE) {
			case ($min == $max):
				$h = 0;
				break;
			case ($max == $r):
				$h = fmod(60 * ($g - $b) / ($max - $min) + 360, 360);
				break;
			case ($max == $g):
				$h = 60 * ($b - $r) / ($max - $min) + 120;
				break;
			case ($max == $b):
				$h = 60 * ($r - $g) / ($max - $min) + 240;
				break;
		}
		
		$s = ($max == 0) ? 0 : 1 - $min / $max;
		$v = $max;
		
		return array(
			(int) round($h),(int) round($s * 255),$v
		);
	}

	function hsv2rgb($h, $s = NULL, $v = NULL) {
		is_array($h) and list($h,$s,$v) = array(
			$h[0],$h[1],$h[2]
		);
		
		$c = $s * $v / 255;
		
		$hh = $h / 60;
		
		$x = $c * (1 - abs(fmod($hh, 2) - 1));
		
		switch (TRUE) {
			case ($hh < 1):
				list($r,$g,$b) = array(
					$c,$x,0
				);
				break;
			case ($hh < 2):
				list($r,$g,$b) = array(
					$x,$c,0
				);
				break;
			case ($hh < 3):
				list($r,$g,$b) = array(
					0,$c,$x
				);
				break;
			case ($hh < 4):
				list($r,$g,$b) = array(
					0,$x,$c
				);
				break;
			case ($hh < 5):
				list($r,$g,$b) = array(
					$x,0,$c
				);
				break;
			case ($hh < 6):
				list($r,$g,$b) = array(
					$c,0,$x
				);
				break;
			default:
				list($r,$g,$b) = array(
					0,0,0
				);
				break;
		}
		
		$m = $v - $c;
		
		return array(
			(int) round($r + $m),(int) round($g + $m),(int) round($b + $m)
		);
	}

	function normalize(&$histogramm, $percent = true) {
		$norm = array_sum($histogramm);
		foreach ($histogramm as & $value) {
			$value = $percent ? (int) round($value / $norm * 100) : $value / $norm;
		}
	}

	function filter(&$histogramm, $threshold) {
		foreach ($histogramm as & $value) {
			if ($value < $threshold) {
				$value = FALSE;
			}
		}
		return $histogramm = array_filter($histogramm);
	}

	function proxy4rgb($color, $range = 'r1g1b1') {
		$proxies = array(
		);
		
		list($c1,$c2,$c3) = self::deformat($color, $c_is_rgb, $c_is_hsv);
		list($r1,$r2,$r3) = self::deformat($range, $r_is_rgb, $r_is_hsv);
		
		if (!$c_is_rgb or !$r_is_rgb) {
			return $proxies;
		}
		
		for ($v1 = max(0, $c1 - $r1); $v1 < min(16, $c1 + $r1 + 1); $v1++) {
			for ($v2 = max(0, $c2 - $r2); $v2 < min(16, $c2 + $r2 + 1); $v2++) {
				for ($v3 = max(0, $c3 - $r3); $v3 < min(16, $c3 + $r3 + 1); $v3++) {
					$proxies[] = sprintf('r%xg%xb%x', $v1, $v2, $v3);
				}
			}
		}
		
		return $proxies;
	}

	function proxy4hsv($color, $range = 'h1s1v1') {
		$proxies = array(
		);
		
		list($c1,$c2,$c3) = self::deformat($color, $c_is_rgb, $c_is_hsv);
		list($r1,$r2,$r3) = self::deformat($range, $r_is_rgb, $r_is_hsv);
		
		if (!$c_is_hsv or !$r_is_hsv) {
			return $proxies;
		}
		
		for ($v1 = $c1 - $r1; $v1 < $c1 + $r1 + 1; $v1++) {
			for ($v2 = max(0, $c2 - $r2); $v2 < min(16, $c2 + $r2 + 1); $v2++) {
				for ($v3 = max(0, $c3 - $r3); $v3 < min(16, $c3 + $r3 + 1); $v3++) {
					$proxies[] = sprintf('h%xs%xv%x', ($v1 + 16) % 16, $v2, $v3);
				}
			}
		}
		
		return $proxies;
	}

	function downsample4rgb($color, $precision = 17) {
		$color[0] = (int) round($color[0] / $precision);
		$color[1] = (int) round($color[1] / $precision);
		$color[2] = (int) round($color[2] / $precision);
		return $color;
	}

	function downsample4hsv($color, $precision = array(
		24,17,17
	)) {
		$color[0] = (int) round($color[0] / $precision[0]);
		$color[1] = (int) round($color[1] / $precision[1]);
		$color[2] = (int) round($color[2] / $precision[2]);
		return $color;
	}

	function getStat() {
		//imagepng($this->image, '1.png');die;
		$histogramm_rgb = array(
		);
		$histogramm_hsv = array(
		);
		
		for ($x = 0; $x < self::width; $x++) {
			for ($y = 0; $y < self::height; $y++) {
				$index = imagecolorat($this->image, $x, $y);
				$rgba = imagecolorsforindex($this->image, $index);
				
				list($r,$g,$b) = self::downsample4rgb(array(
					$rgba['red'],$rgba['green'],$rgba['blue'],
				));
				$rgb_id = sprintf('r%xg%xb%x', $r, $g, $b);
				isset($histogramm_rgb[$rgb_id]) ? $histogramm_rgb[$rgb_id]++ : $histogramm_rgb[$rgb_id] = 1;
				
				list($h,$s,$v) = self::downsample4hsv(self::rgb2hsv($rgba['red'], $rgba['green'], $rgba['blue']));
				$hsv_id = sprintf('h%xs%xv%x', $h, $s, $v);
				isset($histogramm_hsv[$hsv_id]) ? $histogramm_hsv[$hsv_id]++ : $histogramm_hsv[$hsv_id] = 1;
			}
		}
		
		arsort($histogramm_rgb);
		self::normalize($histogramm_rgb);
		self::filter($histogramm_rgb, 4);
		
		arsort($histogramm_hsv);
		self::normalize($histogramm_hsv);
		self::filter($histogramm_hsv, 4);
		
		return $histogramm_rgb + $histogramm_hsv;
	}
}
/*
 $colors = array(
 );
 foreach (array(
 '#000000'
 ) as $color) {
 $rgb = Colors::hex2rgb($color);
 $rgb_s = Colors::rgbDownsample($rgb);
 $rgb_f = Colors::format4rgb($rgb_s);
 $hsv = Colors::rgb2hsv($rgb);
 $hsv_s = Colors::hsvDownsample($hsv);
 $hsv_f = Colors::format4hsv($hsv_s);
 $colors = array_merge($colors, Colors::proxyColor($rgb_f, 'r1g1b1'), Colors::proxyColor($hsv_f, 'h1s1v1'));
 }
 //$colors = array_unique($colors);
 var_dump($colors);
 */
/*
 for ($v1 = 0; $v1 < 256; $v1 += 17) {
 for ($v2 = 0; $v2 < 256; $v2 += 17) {
 for ($v3 = 0; $v3 < 256; $v3 += 17) {
 list($h,$s,$v) = Colors::rgb2hsv($v1, $v2, $v3);
 list($r,$g,$b) = Colors::hsv2rgb($h, $s, $v);
 if ($v1 != $r or $v2 != $g or $v3 != $b) {
 echo "rgb($v1, $v2, $v3) != rgb($r,$g,$b)\n";
 }
 }
 }
 }
 */
/*
 $c = new Colors;
 $c->loadImage('/home/aks/Images/.dummy/pepper.png');
 $s = $c->getStat();
 var_dump($s);
 */
/*
 //$s = Colors::proxyColor('h0s0v0', 'h0s0v0');
 //var_dump($s, count($s));
 */
﻿ 
