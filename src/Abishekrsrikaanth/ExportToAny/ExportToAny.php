<?php

namespace Abishekrsrikaanth\ExportToAny;

use Exporter\Writer\CsvWriter;
use Exporter\Writer\XlsWriter;
use LSS\Array2XML;
use Abishekrsrikaanth\ExportToAny\helpers\ArrayToHtml;

class ExportToAny
{

	/**
	 * Convert an Array to Json
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function toJson(array $data) {
		return json_encode($data);
	}

	/**
	 * Convert an Array to XML
	 *
	 * @param string $root_node_name - name of the root node to be converted
	 * @param array  $data           - array to be converted
	 *
	 * @return \DomDocument
	 */
	public function toXML($root_node_name, array $data) {
		return Array2XML::createXML($root_node_name, $data);
	}

	/**
	 * Convert a 2 dimensional or multi-dimensional array to HTML table. Outputs a HTML Table
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function toHTML(array $data) {
		$obj = new ArrayToHtml();

		return $obj->getHtml($data);
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
	 * @return void
	 */
	public function toCSV($filename, array $data, $delimiter = ",", $enclosure = "\"", $escape = "\\", $showHeaders = true) {
		$csvWriter = new CsvWriter($filename, $delimiter, $enclosure, $escape, $showHeaders);
		$csvWriter->open();
		$csvWriter->write($data);
		$csvWriter->close();
	}

	/**
	 * Exports an Array to an XLS file
	 *
	 * @param       $filename
	 * @param array $data
	 * @param bool  $show_headers
	 */
	public function toXLS($filename, array $data, $show_headers = true) {
		$writer = new XlsWriter($filename, $show_headers);
		$writer->open();

		$writer->write($data);
		$writer->close();
	}
}