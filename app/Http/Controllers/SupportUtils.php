<?php

namespace App\Http;

use Gumlet\ImageResize;
use App\AppConstants;
use App\User;
use Mockery\CountValidator\Exception;

class SupportUtils
{
	public static function getRandomString($length = 16, $uppercase = false)
	{
		$characters = [
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',

			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
			'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
			'U', 'V', 'W', 'X', 'Y', 'Z',

			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
			'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
			'u', 'v', 'w', 'x', 'y', 'z'
		];

		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString = sprintf('%s%s', $randomString, $characters[rand(0, 61)]);
		}

		return $uppercase ? strtoupper($randomString) : $randomString;
	}

	public static function uploadFiles($files, $folder, $prefix)
	{ }

	public static function uploadImages($files, $imageFolder, $prefix, $type = 'jpg')
	{
		$target_dir = str_replace('//', '/', sprintf('images/%s/', $imageFolder));
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0666, true);
		}
		// $extension = mb_strtolower(pathinfo(basename($files['name']), PATHINFO_EXTENSION));
		// $target_file = sprintf('%s%s.%s', $target_dir, SupportUtils::getRandomString(), $extension);
		$target_file = sprintf('%s%s-%s.%s', $target_dir, $prefix, SupportUtils::getRandomString(), $type);

		$error = false;
		try {
			if (file_exists($target_file)) {
				unlink($target_file);
			}

			$image = new ImageResize($files['tmp_name']);
			if ($type === 'png') {
				$image->save($target_file, IMAGETYPE_PNG, 75); // 75 is quality. Max quality is 100
			} else {
				$image->save($target_file, IMAGETYPE_JPEG, 75); // 75 is quality. Max quality is 100
			}
		} catch (Exception $ex) {
			$error = true;
			echo $ex->getTraceAsString();
		}

		if ($error) {
			return '';
		} else {
			return $target_file;
		}
	}

	public static function formatToUrl($name)
	{
		$name = mb_strtolower($name);

		$chars = [];
		for ($i = 0; $i < mb_strlen($name); $i++) {
			$chars[] = mb_substr($name, $i, 1);
		}
		$urlChars = array_fill(0, count($chars), '');

		for ($i = 0; $i < count($chars); $i++) {
			$checkChar = $chars[$i];

			$charIndex = ord($checkChar);
			if (($charIndex > 47 && $charIndex < 58) || ($charIndex > 96 && $charIndex < 123)) {
				$urlChars[$i] = $checkChar;
			} else {
				$isNormalCharacter = false;
				foreach (AppConstants::$dictUrlFormat as $key => $value) {
					if (mb_strpos($value, $checkChar) !== false) {
						$isNormalCharacter = true;
						$urlChars[$i] = $key;
						break;
					}
				}

				if (!$isNormalCharacter) {
					$urlChars[$i] = '-';
				}
			}
		}

		$urlFormatted = trim(join('', $urlChars), '-');
		while (mb_strpos($urlFormatted, '--') !== false) {
			$urlFormatted = str_replace('--', '-', $urlFormatted);
		}

		if ($urlFormatted === '') {
			$urlFormatted = sprintf('content_%s', SupportUtils::getRandomString());
		}

		return $urlFormatted;
	}

	private static function saveBase64ImageToFile($base64, $imageFolder, $prefix, $type = 'jpg')
	{
		$target_dir = str_replace('//', '/', sprintf('images/%s/', $imageFolder));
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0666, true);
		}

		$target_file = sprintf('%s%s-%s.%s', $target_dir, $prefix, SupportUtils::getRandomString(), $type);

		try {
			// Get base64 string
			$base64 = explode(',', $base64)[1];

			$image = ImageResize::createFromString(base64_decode($base64));
			if ($type === 'png') {
				$image->save($target_file, IMAGETYPE_PNG, 75); // 75 is quality. Max quality is 100
			} else {
				$image->save($target_file, IMAGETYPE_JPEG, 75); // 75 is quality. Max quality is 100
			}
		} catch (Exception $ex) {
			$target_file = '';
			echo $ex->getTraceAsString();
		}

		return $target_file;
	}

	public static function changeContentHasBase64ToImagePath($html, $imageFolder, $prefix, &$content_images = [])
	{
		if (!is_array($content_images)) {
			$content_images = [];
		}
		$newHtml = '';

		if (!$html) {
			return $newHtml;
		}

		while (mb_strpos($html, 'src="data:image')) {
			$beginBase64Index = mb_strpos($html, 'src="data:image') + 5;
			$newHtml = sprintf('%s%s', $newHtml, mb_substr($html, 0, $beginBase64Index));
			$html = mb_substr($html, $beginBase64Index);

			$endBase64Index = mb_strpos($html, '"');
			$base64 = mb_substr($html, 0, $endBase64Index);
			$imagePath = SupportUtils::saveBase64ImageToFile($base64, $imageFolder, sprintf('content-%s', $prefix));
			$newHtml = sprintf('%s/%s', $newHtml, $imagePath);
			array_push($content_images, $imagePath);
			$html = mb_substr($html, $endBase64Index);
		}
		$newHtml = sprintf('%s%s', $newHtml, $html);

		return $newHtml;
	}

	public static function changeArrayHasBase64ToImagePath($arr_images, $imageFolder, $prefix)
	{
		if (!is_array($arr_images)) {
			return [];
		}

		for ($i = 0; $i < count($arr_images); $i++) {
			$base64 = $arr_images[$i];
			if (mb_substr($base64, 0, mb_strlen('data:image')) === 'data:image') {
				$arr_images[$i] = SupportUtils::saveBase64ImageToFile($base64, $imageFolder, sprintf('image-%s', $prefix));
			}
		}

		return array_values(array_filter($arr_images));
	}

	public static function urlHistories($back = 1)
	{
		$back = $back < 1 ? 1 : $back;
		$urlHistories = json_decode(request()->session()->get('URL_HISTORIES', '[]'));
		$previousUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

		return !count($urlHistories) || count($urlHistories) < $back ? $previousUrl : $urlHistories[$back - 1];
	}

	public static function checkPosition($id){
        $user = User::find($id);
		$isManagement = $user->position_id == AppConstants::$position_director ||
						$user->position_id == AppConstants::$position_manager ?
						true : false;
		return $isManagement;
	}
}