<?php
/**
 * Password reset
 * @package YetiForce
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @version >= 4.3.0
 */
if (file_exists('include/main/WebUI.php')) {
    include_once 'include/main/WebUI.php';
} else {
    chdir(__DIR__ . '/../');
    if (file_exists('include/main/WebUI.php')) {
        include_once 'include/main/WebUI.php';
    } else {
        chdir(__DIR__ . '/../../');
        if (file_exists('include/main/WebUI.php')) {
            include_once 'include/main/WebUI.php';
        }
    }
}


$userId = 1;
$userName = '';

if ($userName) {
	$userId = \App\User::getUserIdByName($userName);
}
$password = \App\Encryption::generateUserPassword();
$userRecordModel = Users_Record_Model::getInstanceById($userId, 'Users');
$userRecordModel->set('changeUserPassword', true);
$userRecordModel->set('user_password', $password);
$userRecordModel->set('date_password_change', date('Y-m-d H:i:s'));
$userRecordModel->set('force_password_change', 0);
$userRecordModel->save();

echo 'User name: ' . $userRecordModel->get('user_name') . ' | Password: ' . $password;
