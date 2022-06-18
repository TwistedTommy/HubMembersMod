<?php

/**
 * HubMembersMod
 * The Original Automated SMF AirDC++ Web Client Hub Members Mod
 *
 * @package HubMembersMod
 * @description The Original Automated SMF AirDC++ Web Client Hub Members Mod
 * @author HubMembersMod
 * @copyright Copyright (c) 2022 HubMembersMod - All Rights Reserved
 * @license https://github.com/TwistedTommy/HubMembersMod/blob/master/LICENSE
 * @version 0.1
 *
 */

  // Edit these global variable values.
  global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
  $strWebclientUser = "adminUser";
  $strWebclientPass = "adminPass";
  $strWebclientAddress = "https://127.0.0.1:5601";
  $strHubAddress = "adcs://127.0.0.1:5300/?kp=SHA256/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
  $boolHubMembersModEnabled = false;

  /**
   * Registers a hub user.
   *
   * @param array &$regOptions Array of Registration data
   * @param array &$theme_vars Theme specific options (we don't use these)
   * @return string
   *
   */
  function HubMemberRegister(&$regOptions, &$theme_vars) : string {
    global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
    if (!$boolHubMembersModEnabled) {
      return "0";
    }
	$strUsername = $regOptions['username'];
    $strPassword = $regOptions['password'];
	$strUserLevel = "0";
    $arrPostFieldsRegister = array(
      "text" => "+reg nick $strUsername $strUserLevel",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFieldsRegister = json_encode($arrPostFieldsRegister);
    $arrPostFieldsSetPass = array(
      "text" => "+setpass nick $strUsername $strPassword",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFieldsSetPass = json_encode($arrPostFieldsSetPass);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFieldsRegister);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $responseRegister = curl_exec($ch);
    curl_close($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFieldsSetPass);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $responseSetPass = curl_exec($ch);
    curl_close($ch);

    return $responseRegister;
  }

  /**
   * Activates a hub user.
   *
   * @param string $member_name The member's name (since that is guaranteed to be consistent, member id is not)
   * @return string
   *
   */
  function HubMemberActivate($member_name) : string {
    global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
    if (!$boolHubMembersModEnabled) {
      return "0";
    }
	$strUsername = $member_name;
	$strUserLevel = "20";
    $arrPostFields = array(
      "text" => "+upgrade nick $strUsername $strUserLevel",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFields = json_encode($arrPostFields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  /**
   * Resets a hub user pass.
   *
   * @param string $old_user Frequently the same as $user, in some cases it can be an unsanitised version of the username
   * @param string $user The user name
   * @param string $newPassword The newly set password, from whatever source
   * @return string
   *
   */
  function HubMemberResetPass($old_user, $user, $newPassword) : string {
    global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
    if (!$boolHubMembersModEnabled) {
      return "0";
    }
	$strUsername = $user;
    $strPassword = $newPassword;
    $arrPostFields = array(
      "text" => "+setpass nick $strUsername $strPassword",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFields = json_encode($arrPostFields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  /**
   * Delregs a hub user.
   *
   * @param string $user The username.
   * @return string
   *
   */
  function HubMemberDelreg($user) : string {
    global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
    if (!$boolHubMembersModEnabled) {
      return "0";
    }
	$strUsername = $user;
    $arrPostFields = array(
      "text" => "+delreg nick $strUsername",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFields = json_encode($arrPostFields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  /**
   * Changes a hub user nick.
   *
   * @param string $old_user The old nick.
   * @param string $new_user The new nick.
   * @return string
   *
   */
  function HubMemberNickChange($old_user, $new_user) : string {
    global $strWebclientUser, $strWebclientPass, $strWebclientAddress, $strHubAddress, $boolHubMembersModEnabled;
    if (!$boolHubMembersModEnabled) {
      return "0";
    }
	$strUsernameOld = $old_user;
	$strUsernameNew = $new_user;
    $arrPostFields = array(
      "text" => "+nickchange othernick $strUsernameOld $strUsernameNew",
      "third_person" => false,
      "hub_urls" => [
        "$strHubAddress"
      ]
    );
    $strPostFields = json_encode($arrPostFields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strWebclientAddress."/api/v1/hubs/chat_message");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERPWD, "$strWebclientUser:$strWebclientPass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  // Examples.
  // $regOptions['username'] = "testuser";
  // $regOptions['password'] = "IAmTooLam3ToSetAP@ss";
  // $theme_vars = "";
  // $user_id = -1;
  // $new_user = "newtestuser";
  // print_r(json_decode(HubMemberRegister($regOptions, $theme_vars)));
  // print_r(json_decode(HubMemberActivate($regOptions['username'])));
  // print_r(json_decode(HubMemberResetPass($regOptions['username'], $regOptions['username'], $regOptions['password'])));
  // print_r(json_decode(HubMemberNickChange($regOptions['username'], $new_user)));
  // print_r(json_decode(HubMemberDelreg($user_id)));
?>