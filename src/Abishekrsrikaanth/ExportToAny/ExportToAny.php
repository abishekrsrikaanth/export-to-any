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
	 * @param array  $header
	 * @param array  $data
	 * @param string $delimiter
	 *
	 * @return string
	 */
	public function toCSV($filename, array $header, array $data, $delimiter = ',') {
		$handle = fopen($filename, 'w');
		fputcsv($handle, $header, $delimiter);

		foreach ($data as $row) {
			fputcsv($handle, $row, $delimiter);
		}
		fclose($handle);

		return file_get_contents($filename);
	}

	/**
	 * Exports an Array to an XLS file
	 *
	 * @param       $filename
	 * @param array $header
	 * @param array $data
	 *
	 * @return string
	 */
	public function toXLS($filename, array $header, array $data) {
		$handle = fopen($filename, 'w', false);
		fwrite($handle, "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><meta name=ProgId content=Excel.Sheet><meta name=Generator content=\"https://github.com/sonata-project/exporter\"></head><body><table>");

		fwrite($handle, '<tr>');
		foreach ($header as $head) {
			fwrite($handle, sprintf('<td>%s</td>', $head));
		}
		fwrite($handle, '</tr>');

		fwrite($handle, '<tr>');
		foreach ($data as $row) {
			foreach ($row as $value) {
				fwrite($handle, sprintf('<td>%s</td>', $value));
			}
		}
		fwrite($handle, '</tr>');

		fwrite($handle, "</table></body></html>");
		fclose($handle);

		return file_get_contents($filename);
	}
}