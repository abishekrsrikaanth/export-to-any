<?php

namespace Abishekrsrikaanth\ExportToAny\Facades;


use Illuminate\Support\Facades\Facade;

class ExportToAny extends Facade
{
	protected static function getFacadeAccessor()
	{
		return "export-to-any";
	}
}