<?php
header('Content-Type: text/html; charset=utf-8');

$resultSentenceHTML = '';

if (!empty($_POST)) {
	$sentence             = $_POST['sentence'];
	$russianCharCount     = 0;
	$englishCharCount     = 0;
	$resultSentenceStruct = [];

	$chars = preg_split('//u', $sentence, -1, PREG_SPLIT_NO_EMPTY);
	foreach ($chars as $char) {
		if (!preg_match('/[^а-яА-ЯЁё]/u', $char)) {
			$russianCharCount++;
			$resultSentenceStruct[] = [
				'char' => $char,
				'lang' => 'ru',
			];
			continue;
		}

		if (!preg_match('/[^a-zA-Z]/', $char)) {
			$englishCharCount++;
			$resultSentenceStruct[] = [
				'char' => $char,
				'lang' => 'en',
			];
			continue;
		}

		$resultSentenceStruct[] = [
			'char' => $char,
			'lang' => '',
		];
	}

	$isRussianPriority = ($russianCharCount > $englishCharCount);
	foreach ($resultSentenceStruct as $charStruct) {
		if (($charStruct['lang'] === 'en' && $isRussianPriority) || ($charStruct['lang'] === 'ru' && !$isRussianPriority)) {
			$resultSentenceHTML .= '<strong style="color:red">' . $charStruct['char'] . '</strong>';
			continue;
		}

		$resultSentenceHTML .= $charStruct['char'];
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</head>

<body>
<div class="alert alert-primary" role="alert" style="text-align: center;" >
Предметное описание </br>
Латинские символы (A, E, O, P, X и тд.) похожи на кириллицу и наоборот. 
Приложение должно находить и подсвечивать символы, которые не соответствуют языку введенной строки. 
Основные языки: русский и английский. 
Определение языка происходит путем подсчета количества символов. При одинаковом количестве символов в приоритете русский язык. 

</div>
	<form action="" method="post">
	<div class="input-group mb-3">
		<textarea name="sentence" style="text-align: center;" class="form-control w5" placeholder="Введите что-нибудь" aria-label="Введите что-нибудь" aria-describedby="button-addon2"></textarea>
	</div>
		<div class="input-group-append" >
		<input type="submit" class="btn btn-outline-secondary" id="button-addon2" value="Проверить" /><br />
		</div>
	</form>

	<?php echo $resultSentenceHTML; ?>


</body>

</html>