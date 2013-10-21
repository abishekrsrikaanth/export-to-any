<?php
namespace Abishekrsrikaanth\ExportToAny\helpers;


class ArrayToHtml
{
	private $html = '';

	private function do_offset($level) {
		$offset = ""; // offset for subarry
		for ($i = 1; $i < $level; $i++) {
			$offset = $offset . "<td></td>";
		}

		return $offset;
	}

	private function show_array($array, $level, $sub) {
		if (is_array($array) == 1) { // check if input is an array
			foreach ($array as $key_val => $value) {
				$offset = "";
				if (is_array($value) == 1) { // array is multidimensional
					$this->html .= "<tr>";
					$offset = $this->do_offset($level);
					$this->html .= $offset . "<td>" . $key_val . "</td>";
					$this->show_array($value, $level + 1, 1);
				} else { // (sub)array is not multidim
					if ($sub != 1) { // first entry for subarray
						$this->html .= "<tr>";
						$offset = $this->do_offset($level);
					}
					$sub = 0;
					$this->html .= $offset . "<td main " . $sub . " width=\"120\">" . $key_val .
						"</td><td width=\"120\">" . $value . "</td>";
					$this->html .= "</tr>\n";
				}
			} //foreach $array
		} else { // argument $array is not an array
			return;
		}
	}

	public function getHtml($array) {
		$this->html .= "<table border=\"2\">\n";
		$this->show_array($array, 1, 0);
		$this->html .= "</table>\n";

		return $this->html;
	}
}