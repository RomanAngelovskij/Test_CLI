#!/usr/bin/env php
<?php
$BracketsTokens = [
	'{'	=> '}',
	'['	=> ']',
	'('	=> ')'
];
echo "Enter brackets:";
$brackets = preg_replace("|\n|", '', fgets(STDIN));


if (empty($brackets)){
	showError('empty string');
}

$strLen = strlen($brackets);

//Текст должен сожержать только скобки
if (!preg_match("|^[\{\}\(\)\[\]]+$|i", $brackets, $Match)){
	showError('enter only brackets');
}

//При нечетном кол-ве символов, выдаем ошибку и заканчиваем проверку

if ($strLen%2 == 1){
	showError('no paired brackets');
}

$CloseBracketsTokens = array_flip($BracketsTokens);
$Stack = [];
$stackSize = 0;

for($i=0; $i < $strLen; $i++) {
	if (isset($BracketsTokens[$brackets[$i]])){
		$Stack[$stackSize++] = $brackets[$i];
	} elseif (isset($CloseBracketsTokens[$brackets[$i]])) {
		$last = $stackSize ? $Stack[$stackSize-1] : '';
		if ($last != $CloseBracketsTokens[$brackets[$i]]){
			showError('No pair');
		} else {
			unset($Stack[--$stackSize]);
		}
	}
}

if (count($Stack) == 0){
	echo "Result ok \r\n";
} else {
	showError('No pair');
}

function showError($text){
	exit (chr(27) . "[41mError: " . $text . chr(27) . "[0m\r\n");
}
?>