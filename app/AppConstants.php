<?php

namespace App;

class AppConstants
{
	public static $dictUrlFormat = array(
		"a" => "aáàảãạăắằẳẵặâấầẩẫậ",
		"e" => "eéèẻẽẹêếềểễệ",
		"i" => "iíìỉĩị",
		"o" => "oóòỏõọôốồổỗộơớờởỡợ",
		"u" => "uúùủũụưứừửữự",
		"y" => "yýỳỷỹỵ",
		"d" => "dđ"
	);

	// Position
	public static $position_director = 1;
	public static $position_manager = 2;
	public static $position_intern = 3;

	// Approval
	public static $approvalTypeAccept = 1;
	public static $approvalTypeRejected = 2;
	public static $approvalTypeWaiting = 3;

	// Type of day
	public static $am = 'AM';
	public static $pm = 'PM';
	public static $full = 'Full';

	// Type of time
	public static $typePTO = 1;
	public static $typeHoliday = 2;
	public static $typeOrther = 3;

	// App
	public static $hoursWorkADay = 8;
	public static $monthExpire = 3;

	// Redis
	public static $timeExpireRedis = 300;
	// public static $timeExpireRedis = 10;

	// Work statistics
	public static $directionIn = 'in';
	public static $directionOut = 'out';

	// Type
	public static $commandCreate = 1;
	public static $commandUpdate = 2;

	// Encrypt KEY
	public static $ENCRYPTION_KEY = '!@#$%^&*(CHNSolution)';
}
