<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2016, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://about.ph7.me
 */

namespace Mailing;

use GetResponse\GetResponse;

class MailingList
{
	const API_KEY = 'API_KEY';
	const CAMPAIGN_ID = 'TOKEN_ID'; // Token ID
	const FIELD_ID_URL = 'CUSTOM_ID_FIELD'; // ph7cmsurl custom field ID. I got the ID by using [GET]/v3/custom-fields and fetch all fields to see the ["ph7cmsurl" customFieldId].
	const FROM_FIELD_ID = 'CUSTOM_FROM_FIELD_ID'; // Same than MailingList::FIELD_ID_URL
	
	private $oApi;
	
	public function __construct()
	{
		$this->oApi = new GetResponse(static::API_KEY);
		
		$sName = $this->getPost('name');
		$sEmail = $this->getPost('email');
		$sIp = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$aParams = [
		    'email' => $sEmail,
		    'name' => $sName,
		    'campaign' => ['campaignId' => static::CAMPAIGN_ID],
		    'dayOfCycle' => 0,
		    'customFieldValues' => [['customFieldId' => static::FIELD_ID_URL, 'value' => [$this->getPost('ph7cmsurl')]]],
		    'ipAddress' => $sIp
		];
		$this->oApi->addContact($aParams);
		/*
        $this->oApi->sendNewsletter([
            'subject' => 'Validate your Site',
            'fromField' => ['fromFieldId' => static::FROM_FIELD_ID],
            'campaign' => ['campaignId' => static::CAMPAIGN_ID],
            'content' => [
                'html' => 'Hi ' . $sName . '!<br /><br />
                Thanks a lot for registering your website. To confirm it, please just <a href="' . $this->getPost('ph7cmsvalidatorurl') . '/JkdjkPh7Pd5548OOSdgPU_92AIdO">click here</a>.<br />
                You will now also now be entitled to receive security patch emails and news concerning the software and the social dating business (normally never more than 4/6 per year..).<br /><br />
                Please let me know if you have any other questions by replying to this email or just email me at <a href="mailto:hello@ph7cms.com">hello@ph7cms.com</a>.<br /><br />
                Thanks a mil!'
            ],
            'sendSettings' => [
                 'selectedContacts' => [$this->oApi->getContacts(['query' => ['email' => $sEmail], 'fields' => 'email'])]
            ]
        ]);
*/
        header('Location: ' . $this->getPost('ph7cmspendingurl'));
        exit;
	}
	
	protected function getPost($sVal)
	{
		return (!empty($_POST[$sVal])) ? strip_tags($_POST[$sVal]) : '';
	}
}
