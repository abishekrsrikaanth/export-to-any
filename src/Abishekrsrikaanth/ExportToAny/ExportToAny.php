<?php

namespace Abishekrsrikaanth\ExportToAny;

use Exporter\Writer\CsvWriter;
use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use LSS\Array2XML;
use Abishekrsrikaanth\ExportToAny\helpers\ArrayToHtml;

class ExportToAny
{

	/**
	 * Convert an Array to Json
	 *
	 * @param       $file_name
	 * @param array $data
	 *
	 * @return string
	 */
	public function toJson($file_name, array $data) {
		$json_data = json_encode($data);
		file_put_contents($file_name, $json_data);

		return $json_data;
	}

	/**
	 * Convert an Array to XML
	 *
	 * @param        $file_name
	 * @param string $root_node_name - name of the root node to be converted
	 * @param array  $data           - array to be converted
	 *
	 * @internal param $child_node_name
	 * @return string
	 */
	public function toXML($file_name, $root_node_name, array $data) {
		$xmlObj = Array2XML::createXML($root_node_name, $data);
		$xml    = $xmlObj->saveXML();
		file_put_contents($file_name, $xml);

		return $xml;
	}

	/**
	 * Convert a 2 dimensional or multi-dimensional array to HTML table. Outputs a HTML Table
	 *
	 * @param       $file_name
	 * @param array $data
	 *
	 * @return string
	 */
	public function toHTML($file_name, array $data) {
		$obj   = new ArrayToHtml();
		$table = $obj->getHtml($data);
		$html  = "<html><body>{content}</body></html>";
		file_put_contents($file_name, str_replace("{content}", $table, $html));

		return $table;
	}

	/**
	 * Exports an Array to a CSV file
	 *
	 * @param        $filename
	 * @param        $data
	 * @param string $delimiter
	 * @param string $enclosure
	 * @param string $escape
	 * @param bool   $showHeaders
	 *
	 * @return string
	 */
	public function toCSV($filename, array $data, $delimiter = ",", $enclosure = "\"", $escape = "\\", $showHeaders = true) {
		$csvWriter = new CsvWriter($filename, $delimiter, $enclosure, $escape, $showHeaders);
		$csvWriter->open();
		foreach ($data as $row) {
			$csvWriter->write($row);
		}
		$csvWriter->close();

		return file_get_contents($filename);
	}

	/**
	 * Exports an Array to an XLS file
	 *
	 * @param       $filename
	 * @param array $data
	 * @param bool  $show_headers
	 *
	 * @return string
	 */
	public function toXLS($filename, array $data, $show_headers = true) {
		$writer = new XlsWriter($filename, $show_headers);
		$writer->open();

		$writer->write($data);
		$writer->close();

		return file_get_contents($filename);
	}
}