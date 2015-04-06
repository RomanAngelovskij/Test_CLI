#!/usr/bin/env php
<?php
class Table{

	/**
	 * @var array Названия столбков таблицы
	 */
	private $__Header;

	/**
	 * @var array Данные таблицы
	 */
	private $__Data;


	/**
	 * @var array Массив с параметрами столбцов.
	 * 			  Например, width - ширина столбца в знаках
	 */
	private $__TableProperties;

	public function __construct(){}


	/**
	 * Обработка таблицы и ее печать
	 */
	public function process(){
		$this->__calculateWidth()
			 ->__drawHeader();

		foreach ($this->__Data as $Data){
			$this->__drawRow($Data);
		}
	}


	/**
	 *  Установка шапки таблицы
	 *
	 * @param array $Header Одномерный массив с названиями столбцов таблицы
	 *
	 * @return $this
	 * @throws Exception
	 */public function setHeader($Header){
		if (empty($Header)){
			throw new Exception('Empty header');
		}

		$this->__Header = $Header;

		return $this;
	}


	/**
	 * Установка данных таблицы
	 *
	 * @param array $Data Массив с данными таблицы
	 *
	 * @return $this
	 * @throws Exception
	 */public function setData($Data){
		if (empty($Data)){
			throw new Exception('Empty table data');
		}

		$this->__Data = $Data;

		return $this;
	}


	/**
	 * Расчет ширины столбцов
	 *
	 * @return $this
	 */
	private function __calculateWidth(){
		foreach ($this->__Header as $indx => $cell){
			$this->__TableProperties[$indx] = ['width' => strlen($cell)];
		}

		foreach ($this->__Data as $Row){
			foreach ($Row as $indx => $cell){
				if (strlen($cell) > $this->__TableProperties[$indx]['width']){
					$this->__TableProperties[$indx]['width'] = strlen($cell);
				}
			}
		}

		return $this;
	}

	/**
	 * отрисовка шапки таблицы
	 *
	 * @return $this
	 */
	private function __drawHeader(){
		$this->__drawHorizontalBorder();

		foreach ($this->__TableProperties as $indx => $Property){
			echo '|  ' . $this->__Header[$indx] . '   ';
		}

		echo "|\r\n";

		$this->__drawHorizontalBorder();

		return $this;
	}

	/**
	 * Отрисовка строки таблицы с данными
	 *
	 * @param array $Data Массив с данными строки
	 *
	 * @return $this
	 */private function __drawRow($Data){
		foreach ($this->__TableProperties as $indx => $Property){
			echo '|' . $Data[$indx] . str_repeat(' ', $Property['width']-strlen($Data[$indx])+4);
		}

		echo "|\r\n";

		$this->__drawHorizontalBorder();

		return $this;
	}


	/**
	 * Отрисовка горизонтальной линии для разделения строк
	 */
	private function __drawHorizontalBorder(){
		foreach ($this->__TableProperties as $indx => $Property){
			echo '+' . str_repeat('-', $Property['width']+4);
		}

		echo "+\r\n";
	}
}

$data = '[["String","Number","Color"],["string 1",1,"red"],["string 2",2,"blue"]]';
$TableData = json_decode($data, true);

$Table = new Table();

$Table->setHeader($TableData[0]);
unset($TableData[0]);
$Table->setData($TableData);

$Table->process();
?>